<?php

namespace frontend\controllers;

use common\models\Coupon;
use common\models\Order;
use Yii;
use yii\data\ArrayDataProvider;
use yii\i18n\Formatter;
use yii\web\NotFoundHttpException;
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

    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionFastCreate()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = new Order(false, ['scenario' => 'short']);
            $response['success'] = false;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $response['success'] = true;
                $response['message'] = 'Ваш заказ принят! Ожидайте, в ближайшее время с Вами свяжутся.';
                return $response;
            }
            return $response['errors'] = $model->errors;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     */
    public function actionConfirm()
    {
        $model = new Order(Yii::$app->session['discount']);
        if ($model->load(Yii::$app->request->post())) {

            if ($model->save()) {
                $items = $model->setOrderId();
                $dataProvider = new ArrayDataProvider([
                    'allModels' => $items
                ]);

                return $this->render('success', [
                    'model' => $model,
                    'dataProvider' => $dataProvider
                ]);
            }
            return $this->redirect('cart/view');
        }
        return $this->render('index', ['model' => $model]);
    }
}
