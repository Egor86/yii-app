<?php

namespace frontend\controllers;

use common\models\PreOrder;
use common\models\Subscriber;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class PreOrderController extends \yii\web\Controller
{
    public function actionCreate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response['success'] = false;
            $model = new PreOrder();
            if ($model->load(Yii::$app->request->post())) {
                if (!$model->save()) {
                    return $response['errors'] = $model->firstErrors;
                }
                return $response['success'] = true;
            }
            return $response;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
