<?php

namespace backend\controllers;

use common\models\ImageStorage;
use Yii;
use yii\web\Response;

class ImageController extends \yii\web\Controller
{
    public function actionDelete($id)
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if (ImageStorage::findOne($id)->delete()){
                return true;
            }
            return false;
        }

        return false;
    }
}
