<?php

namespace backend\models\search;

use common\models\ProductColorSize;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\ProductColor;

/**
 * ProductColorSearch represents the model behind the search form about `common\models\ProductColor`.
 */
class ProductColorSearch extends ProductColor
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'product_id', 'color_id'], 'integer'],
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
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = ProductColor::find()->joinWith('productColorSizes')->where(['product_id' => $params['id']]);
        // add conditions that should always apply here
//        echo '<pre>';
//        @print_r($query);
//        echo '</pre>';
//        exit(__FILE__ .': '. __LINE__);
        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);
//
//        $this->load($params);

//        if (!$this->validate()) {
//            // uncomment the following line if you do not want to return any records when validation fails
//            // $query->where('0=1');
//            return $dataProvider;
//        }

        // grid filtering conditions
//        $query->andFilterWhere([
//            'id' => $this->id,
//            'product_id' => $this->product_id,
//            'color_id' => $this->color_id,
//        ]);

        return $dataProvider;
    }
}
