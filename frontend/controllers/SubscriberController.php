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
    public function actionCreate()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $model = Subscriber::findOne(['email' => $post['Subscriber']['email'], 'phone' => $post['Subscriber']['phone']]);
            if (!$model) {
                $model = new Subscriber();
                if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
                    Yii::$app->session->setFlash('message', current($model->getFirstErrors()));
                    return $this->redirect(Yii::$app->request->referrer);
                }
            }
            if (!Coupon::findOne(['subscriber_id' => $model->id])) {
                try{
                    $model->trigger(Coupon::EVENT_GET_COUPON);
                } catch (Exception $e) {
                    Yii::$app->session->setFlash('message', $e->getMessage());
                    return $this->redirect(Yii::$app->request->referrer);
                }
                Yii::$app->session->setFlash('message');
                return $this->redirect(Yii::$app->getHomeUrl());
            }
            Yii::$app->session->setFlash('message',"Клиент с телефоном {$model->phone} и email {$model->email} уже получил купон");
            return $this->redirect(Yii::$app->request->referrer);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

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
