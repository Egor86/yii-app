<?php

namespace frontend\controllers;

use common\models\Coupon;
use common\models\Subscriber;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class SubscriberController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

//    public function actionCreate()     // Prod version
//    {
//        if (Yii::$app->request->isAjax) {
//            $model = new Subscriber();
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                $model->trigger(Coupon::EVENT_GET_COUPON);
//                return true;
//            }
//            return $model->errors;
//        }
//        throw new NotFoundHttpException('The requested page does not exist.');
//    }

    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $model = new Subscriber();
            $model->trigger(Coupon::EVENT_GET_COUPON);
//            if ($model->load(Yii::$app->request->post()) && $model->save()) {
//                $model->trigger(Coupon::EVENT_GET_COUPON);
//                return true;
//            }
            return $model->errors;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
