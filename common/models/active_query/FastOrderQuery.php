<?php

namespace common\models\active_query;
use common\models\FastOrder;

/**
 * This is the ActiveQuery class for [[FastOrder]].
 *
 * @see FastOrder
 */
class FastOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return FastOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return FastOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
