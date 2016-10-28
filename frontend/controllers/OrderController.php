<?php

namespace frontend\controllers;

use common\models\Coupon;
use common\models\Order;
use Yii;
use yii\data\ArrayDataProvider;
use yii\i18n\Formatter;
use yii\web\Response;

class OrderController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionFastCreate()
    {
        $model = new Order(['scenario' => 'fast']);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                return 'Ваш заказ принят! Ожидайте, в ближфйшее время с Вами свяжутся.';
            }
        }
        return $this->render('fast-create', [
            'model' => $model,
        ]);
    }

    public function actionConfirm()
    {
        $model = new Order(Yii::$app->session['discount']);

        if (Yii::$app->request->post()) {
            if ($model->load(Yii::$app->request->post())) {

                $cart = Yii::$app->cart;
                $model->value = Yii::$app->session[$cart->id];
                $model->total_cost = $cart->getCost(true);
                if ($model->save()) {
                    Yii::$app->session->removeAll();
//                    $cart->deleteAll();
                    $dataProvider = new ArrayDataProvider([
                        'allModels' => unserialize($model->value)
                    ]);

                    return $this->render('success', [
                        'model' => $model,
                        'dataProvider' => $dataProvider
                    ]);
                }
            }
        }
        return $this->render('index', ['model' => $model]);
    }
}
