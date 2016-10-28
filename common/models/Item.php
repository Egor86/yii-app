<?php

namespace common\models;

use common\behavior\SeoBehavior;
use hscstudio\cart\CartPositionTrait;
use Yii;

/**
 * This is the model class for table "item".
 *
 * @property integer $id
 * @property integer $product_id
 * @property integer $color_id
 * @property string $name
 * @property string $slug
 * @property string $stock_keeping_unit
 * @property string $price
 * @property string $discount_price
 * @property integer $created_at
 * @property integer $updated_at
 */
class Item extends \yii\db\ActiveRecord
{
    use CartPositionTrait;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'color_id', 'name', 'slug', 'stock_keeping_unit', 'price'], 'required'],
            [['product_id', 'color_id'], 'integer'],
            [['price', 'discount_price'], 'number'],
            [['name', 'slug', 'stock_keeping_unit'], 'string', 'max' => 45],
            ['slug', 'match', 'pattern' => '/^[a-zA-Z-]+$/', 'message' => 'URL может состоять из латиницы и тире'],
            [['stock_keeping_unit'], 'unique'],
            [['slug'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'color_id' => 'Цвет',
            'name' => 'Наименование',
            'slug' => 'URL',
            'stock_keeping_unit' => 'Артикул',
            'price' => 'Цена',
            'discount_price' => 'Цена со скидкой',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
        ];
    }

    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    \yii\db\ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    \yii\db\ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
            'seoBehavior' => SeoBehavior::className(),
        ];
    }

    /**
     * Usage for update Items images
     * @return array|ImageStorage[]
     */
    public function getImages()
    {
        return ImageStorage::find()->where(['class' => self::className(), 'class_item_id' => $this->id])->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getColor()
    {
        return $this->hasOne(Color::className(), ['id' => 'color_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getSizes()
    {
        return $this->hasMany(Size::className(), ['id' => 'size_id'])
            ->viaTable(ItemSize::tableName(),['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['item_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * @inheritdoc
     * @return \common\models\active_query\ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new \common\models\active_query\ItemQuery(get_called_class());
    }

    /**
     * @param array $params Parameters for cart position
     * @return object CartPositionInterface
     */
    public function getCartPosition($params = [])
    {
        $params['class'] = 'common\models\ItemCartPosition';
        return \Yii::createObject($params);
    }
}
