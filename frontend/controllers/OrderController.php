<?php

namespace frontend\controllers;

use common\models\Order;
use Yii;
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

    public function actionClear()
    {
        return $this->render('clear');
    }

    public function actionCreate()
    {
        return $this->render('create');
    }

    public function actionFastCreate()
    {
        $model = new Order(['scenario' => 'fast']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                Yii::$app->response->format = Response::FORMAT_JSON;
                // form inputs are valid, do something here
                return 'Ваш заказ принят! Ожидайте, в ближфйшее время с Вами свяжуться.';
            }
        }

        return $this->render('fast-create', [
            'model' => $model,
        ]);
    }


    public function actionIndex()
    {
        return $this->render('index');
    }

}
