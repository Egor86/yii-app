<?php

namespace frontend\models;

use common\models\Category;
use common\models\Product;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Item;

/**
 * ItemSearch represents the model behind the search form about `common\models\Item`.
 * @property array $size
 * @property array $color
 * @property integer $min
 * @property integer $max
 * @property array $limit
 */
class ItemSearch extends Item
{
    public $size;
    public $min;
    public $max;
    public $limit;
    public $color;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['max', 'min'], function($attribute, $params) {
                $this->$attribute = intval(str_replace(' ', '', $this->$attribute));
            }],
            ['limit', function($attribute, $params) {
                $this->$attribute = max($this->$attribute);
            }],
            [['id', 'product_id',  'created_at', 'updated_at', 'status', 'recommended', 'isDeleted', 'min', 'max', 'limit'], 'integer'],
            [['name', 'slug', 'stock_keeping_unit', 'color', 'size'], 'safe'],
            [['price', 'discount_price'], 'number'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     * @param $category Category
     * @return ActiveDataProvider
     */
    public function search($params, $category)
    {
        if ($category->parent) {
            $product_ids = Product::find()
                ->where(['category_id' => $category->id])
                ->asArray()
                ->column();
        } else {
            $product_ids = Product::find()
                ->where(['in', 'category_id',
                    Category::find()
                        ->where(['parent' => $category->id])
                        ->asArray()
                        ->column()])
                ->column();
        }


        $query = Item::find()
            ->where(['in', 'product_id', $product_ids])
            ->andWhere(['isDeleted' => false])->joinWith('itemSizes');
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => $this->limit ? $this->limit : 30,
            ],
        ]);

        $this->setAttributes($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        $dataProvider->setSort([
            'attributes' => [
                'new' => [
                    'desc' => ['created_at' => SORT_DESC],
                    'asc' => ['created_at' => SORT_ASC],
                    'label' => 'Сначала новые',
                ],
                'price_high' => [
                    'desc' => ['price' => SORT_DESC],
                    'asc' => ['price' => SORT_ASC],
                    'label' => 'Сначала дорогие',
                ],
                'price_low' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'label' => 'Сначала дешевые',
                ],
                'discount' => [
                    'asc' => ['discount_price' => SORT_ASC],
                    'desc' => ['discount_price' => SORT_DESC],
                    'label' => 'Только со скидкой',
                ],
            ],
        ]);

        if (isset($params['sort']) && $params['sort'] == 'discount') {
            $query->andFilterWhere(['>', 'discount_price', 0]);
        }

        if ($this->max) {
            $query->andFilterWhere(['between', 'price', $this->min, $this->max]);
        }

        $query->andFilterWhere(['like', 'stock_keeping_unit', $this->stock_keeping_unit])
            ->andFilterWhere(['in', 'color_id', $this->color])
            ->andFilterWhere(['in', 'item_size.size_id', $this->size]);

        return $dataProvider;
    }
}
