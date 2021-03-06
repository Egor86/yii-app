<?php

namespace common\models\active_query;
use common\models\Seo;

/**
 * This is the ActiveQuery class for [[Seo]].
 *
 * @see Seo
 */
class SeoQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return Seo[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return Seo|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
