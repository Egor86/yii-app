<?php

namespace common\models\active_query;

/**
 * This is the ActiveQuery class for [[\common\models\PreOrder]].
 *
 * @see \common\models\PreOrder
 */
class PreOrderQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\PreOrder[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\PreOrder|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
