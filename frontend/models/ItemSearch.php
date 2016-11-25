<?php

namespace frontend\models;

use common\models\Product;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Item;

/**
 * ItemSearch represents the model behind the search form about `common\models\Item`.
 * @property array $sizes
 */
class ItemSearch extends Item
{
    public $sizes;
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'color_id', 'created_at', 'updated_at', 'status', 'recommended', 'isDeleted'], 'integer'],
            [['name', 'slug', 'stock_keeping_unit', 'sizes'], 'safe'],
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
     * @param integer $category_id
     * @return ActiveDataProvider
     */
    public function search($params, $category_id)
    {
        $product_ids = Product::find()->where(['category_id' => $category_id])->asArray()->column();
        $query = Item::find()
            ->where(['in', 'product_id', $product_ids])->andWhere(['isDeleted' => false]);

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'defaultPageSize' => isset($params['limit']) ?
                    $params['limit'] :
                    1
            ],
        ]);

        $this->load($params);

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
                'discount_price' => [
                    'default' => SORT_DESC,
                    'label' => 'Только со скидкой',
                ],
            ],
        ]);

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'product_id' => $this->product_id,
            'color_id' => $this->color_id,
            'price' => $this->price,
            'discount_price' => $this->discount_price,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'status' => $this->status,
            'recommended' => $this->recommended,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'slug', $this->slug])
            ->andFilterWhere(['like', 'stock_keeping_unit', $this->stock_keeping_unit]);

        return $dataProvider;
    }
}
