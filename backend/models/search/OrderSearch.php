<?php

namespace backend\models\search;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Order;

/**
 * OrderSearch represents the model behind the search form about `common\models\Order`.
 */
class OrderSearch extends Order
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'coupon_id', 'status', 'created_at', 'updated_at', 'sort_by'], 'integer'],
            [['name', 'surname', 'country', 'region', 'city', 'address', 'organization_name', 'post_index', 'phone', 'email', 'delivery_date'], 'safe'],
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
     *
     * @param bool $other If true show ORDER_REVOKED and ORDER_DONE instead fast? new and processed
     * @return ActiveDataProvider
     */
    public function search($params, $other = false)
    {
        $query = Order::find()
            ->where(['not in', 'status', [Order::ORDER_DONE, Order::ORDER_REVOKED]])
            ->orderBy(['status' => SORT_ASC, 'created_at' => SORT_ASC]);

        if ($other) {
            $query = Order::find()
                ->where(['not in', 'status', [Order::ORDER_FAST, Order::ORDER_NEW, Order::ORDER_PROCESSED]])
                ->orderBy(['updated_at' => SORT_ASC]);
        }
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
//            'delivery_date' => $this->delivery_date,
            'coupon_id' => $this->coupon_id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort_by' => $this->sort_by,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'surname', $this->surname])
            ->andFilterWhere(['like', 'country', $this->country])
            ->andFilterWhere(['like', 'region', $this->region])
            ->andFilterWhere(['like', 'city', $this->city])
            ->andFilterWhere(['like', 'address', $this->address])
            ->andFilterWhere(['like', 'organization_name', $this->organization_name])
            ->andFilterWhere(['like', 'post_index', $this->post_index])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['delivery_date' => $this->delivery_date]);

        return $dataProvider;
    }
}
