<?php

namespace common\models\active_query;

/**
 * This is the ActiveQuery class for [[\common\models\VideoStorage]].
 *
 * @see \common\models\VideoStorage
 */
class VideoStorageQuery extends \yii\db\ActiveQuery
{
    /*public function active()
    {
        return $this->andWhere('[[status]]=1');
    }*/

    /**
     * @inheritdoc
     * @return \common\models\VideoStorage[]|array
     */
    public function all($db = null)
    {
        return parent::all($db);
    }

    /**
     * @inheritdoc
     * @return \common\models\VideoStorage|array|null
     */
    public function one($db = null)
    {
        return parent::one($db);
    }
}
