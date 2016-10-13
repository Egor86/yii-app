<?php

namespace common\models\active_query;

/**
 * This is the ActiveQuery class for [[\common\models\ProductSizeColor]].
 *
 * @see \common\models\ProductSizeColor
 */
class ProductSizeColorQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\ProductSizeColor[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\ProductSizeColor|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
