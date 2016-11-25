<?php

namespace backend\models\search;

use common\models\Coupon;
use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\Subscriber;

/**
 * SubscriberSearch represents the model behind the search form about `common\models\Subscriber`.
 */
class SubscriberSearch extends Subscriber
{
    public $couponUsingStatus;
    public $coupon;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'created_at', 'updated_at', 'sort_by'], 'integer'],
            [['name', 'email', 'phone', 'euid', 'leid', 'coupon', 'couponUsingStatus','mail_chimp_status'], 'safe'],
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
        $query = Subscriber::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'sort' => false
        ]);

        $this->load($params);

        if (!$this->coupon) {
            $query->joinWith('coupon')->andFilterWhere(['not in', 'subscriber_id', $this->coupon]);
        } elseif ($this->coupon) {
            $query->leftJoin('coupon', 'subscriber.id = coupon.subscriber_id')
                ->andFilterWhere(['not in', 'subscriber.id', Coupon::find()->select('subscriber_id')->asArray()->column()]);
        }

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'sort_by' => $this->sort_by,
            'mail_chimp_status' => $this->mail_chimp_status,
        ]);

        $query->andFilterWhere(['like', 'name', $this->name])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'phone', $this->phone])
            ->andFilterWhere(['like', 'euid', $this->euid])
            ->andFilterWhere(['like', 'leid', $this->leid])
            ->andFilterWhere(['like', 'mail_chimp_status', $this->mail_chimp_status])
            ->andFilterWhere(['like', 'coupon.using_status', $this->couponUsingStatus]);;

        return $dataProvider;
    }
}
