<?php

namespace common\models;

use common\behavior\SeoBehavior;
use common\models\active_query\ItemQuery;
use hscstudio\cart\CartPositionTrait;
use Yii;
use yii2tech\ar\softdelete\SoftDeleteBehavior;

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
 * @property integer $status
 * @property integer $recommended
 * @property integer $isDeleted
 */
class Item extends \yii\db\ActiveRecord implements \mrssoft\sitemap\SitemapInterface
{
    use CartPositionTrait;

    const PUBLISHED = 1;
    const UNPUBLISHED = 0;
    const UNRECOMMENDED = 0;
    const RECOMMENDED = 1;
    const ITEM_VIEW_LIMIT_DESKTOP = 8;
    const ITEM_VIEW_LIMIT_MOBILE = 2;


    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'item';
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            foreach ($this->getImages() as $image) {
                $image->delete();
            }
            foreach ($this->itemSizes as $itemSize) {
                $itemSize->delete();
            }

            foreach ($this->comments as $comment) {
                $comment->delete();
            }
            return true;
        }
        return true;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['product_id', 'color_id', 'name', 'slug', 'stock_keeping_unit', 'price'], 'required'],
            [['product_id', 'color_id', 'recommended', 'status'], 'integer'],
            [['price', 'discount_price'], 'number'],
            [['name', 'slug', 'stock_keeping_unit'], 'string', 'max' => 45],
            ['slug', 'match', 'pattern' => '/^[a-zA-Z-]+$/', 'message' => 'URL может состоять из латиницы и тире'],
            [['stock_keeping_unit'], 'unique'],
            [['slug'], 'unique'],
            ['color_id', 'checkUnique']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Родительский продукт',
            'color_id' => 'Цвет',
            'name' => 'Наименование',
            'slug' => 'URL',
            'stock_keeping_unit' => 'Артикул',
            'price' => 'Цена',
            'discount_price' => 'Цена со скидкой',
            'created_at' => 'Дата создания',
            'updated_at' => 'Дата обновления',
            'status' => 'Опубликован?',
            'recommended' => 'Популярный товар'
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
//            'softDeleteBehavior' => [
//                'class' => SoftDeleteBehavior::className(),
//                'softDeleteAttributeValues' => [
//                    'isDeleted' => true,
//                ],
//            ],
        ];
    }

    /**
     * Usage for update Items images & for item view - frontend
     * @return array|ImageStorage[]
     */
    public function getImages()
    {
        return ImageStorage::find()->where(['class' => self::className(), 'class_item_id' => $this->id])->all();
    }

    public function getImage($type)
    {
        return ImageStorage::findOne(['class' => self::className(), 'class_item_id' => $this->id, 'type' => $type]);
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
    public function getPreOrders()
    {
        return $this->hasMany(PreOrder::className(), ['item_id' => 'id']);
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
    public function getItemSizes()
    {
        return $this->hasMany(ItemSize::className(), ['item_id' => 'id']);
    }
    /**
     * Search all sizes by items category
     * @return array|Size[]
     */
    public function getSizeTable()
    {
        return Size::find()
            ->where(['size_table_name_id' => Category::findOne($this->product->category_id)->size_table_name_id])
            ->asArray()
            ->all();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['item_id' => 'id'])->where(['agree' => true]);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }

    /**
     * Get size_id sizes with amount > 0
     * Usage
     * 1.ItemController::actionGetSize() in view with depDrop select
     * 2. In Order view GridView
     * 3. ItemController::actionGetSize
     * @return array
     */
    public function getPresentSizes()
    {
        return ItemSize::find()->select('size_id')->where(['item_id' => $this->id])->andWhere(['>', 'amount', 0])->column();
    }

    /**
     * @return mixed
     */
    public function getAmount()
    {
        return ItemSize::find()->where(['item_id' => $this->id])->sum('amount');
    }

    public function checkUnique($attribute, $params)
    {
        $is_unique = array_flip(self::find()->select('id')->where(['product_id' => $this->product_id, $attribute => $this->color_id])->column());

        if (key_exists($this->id, $is_unique)) {
            unset($is_unique[$this->id]);
        }

        if (!empty($is_unique)) {
            $color = Color::findOne($this->color_id);
            $this->addError($attribute, "Товар данного продукта цвета - '{$color->name}'  уже существует");
            return false;
        }
        return true;
    }

    /**
     * @inheritdoc
     * @return ItemQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ItemQuery(get_called_class());
    }

    /**
     * @param array $params Parameters for cart position
     * @return object CartPositionInterface
     */
    public function getCartPosition($params = [])
    {
        $params['class'] = 'common\models\ItemCartPosition';
        return Yii::createObject($params);
    }

    public static function sitemap()
    {
        return self::find()->where(['isDeleted' => false, 'status' => true]);
    }

    /**
     * @return string
     */
    public function getSitemapUrl()
    {
        return  \yii\helpers\Url::toRoute(['item/view', 'slug' => $this->slug], true);
    }
}
