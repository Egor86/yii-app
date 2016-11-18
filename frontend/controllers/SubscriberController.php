<?php

namespace frontend\controllers;

use common\models\Coupon;
use common\models\Subscriber;
use Yii;
use yii\base\Exception;
use yii\web\HttpException;
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

    public function actionCreate()     // Prod version
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response['success'] = false;
            $post = Yii::$app->request->post();
            $model = Subscriber::findOne(['email' => $post['Subscriber']['email'], 'phone' => $post['Subscriber']['phone']]);
            if (!$model) {
                $model = new Subscriber();
                if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
                    $response['errors'] = $model->firstErrors;
                    return $response;
                }
            }
            if (!Coupon::findOne(['subscriber_id' => $model->id])) {
                try{
                    $model->trigger(Coupon::EVENT_GET_COUPON);
                } catch (Exception $e) {
                    $response['errors'] = $e->getMessage();
                    return $response;
                }
                $response['success'] = true;
                $response['message'] = 'Купон был отправлен вам на email';
                return $response;
            }
            $response['errors'] = "Клиент с телефоном {$model->phone} и email {$model->email} уже получил купон";
            return $response;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

//    public function actionSoon()
//    {
//        $subscriber = new Subscriber();
//
//        if (Yii::$app->request->isAjax) {
//            Yii::$app->response->format = Response::FORMAT_JSON;
//            $post = Yii::$app->request->post();
//            $model = Subscriber::findOne(['email' => $post['Subscriber']['email'], 'phone' => $post['Subscriber']['phone']]);
//            if (!$model) {
//                $model = new Subscriber();
//                try{
//                if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
//                    return current($model->firstErrors);
//                }
//                } catch (Exception $e) {
//                    return $e->getMessage();
//                }
//            }
//            if (!Coupon::findOne(['subscriber_id' => $model->id])) {
//                try{
//                    $model->trigger(Coupon::EVENT_GET_COUPON);
//                } catch (Exception $e) {
//                    return $e->getMessage();
//                }
//                return 'Купон был отправлен вам на email';
//            }
//            $message = "Клиент с телефоном {$model->phone} и email {$model->email} уже получил купон";
//            return $message;
//        }
//        return $this->renderPartial('index', ['model' => $subscriber]);
//    }

    public function actionSoon()
    {
        $subscriber = new Subscriber();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $response['success'] = false;
            $post = Yii::$app->request->post();
            $model = Subscriber::findOne(['email' => $post['Subscriber']['email'], 'phone' => $post['Subscriber']['phone']]);
            if (!$model) {
                $model = new Subscriber();
                if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
                    $response['message'] = current($model->getFirstErrors());
                    return $response;
                }
            }
            if (!Coupon::findOne(['subscriber_id' => $model->id])) {
                try {
                    $model->trigger(Coupon::EVENT_GET_COUPON);
                } catch (Exception $e) {
                    $response['message'] = $e->getMessage();
                    return $response;
                }
                $response['success'] = true;
                return $response;
            }
            $response['message'] = "Клиент с телефоном {$model->phone} и email {$model->email} уже получил купон";
            return $response;
        }
        return $this->renderPartial('index', ['model' => $subscriber]);
    }
}
