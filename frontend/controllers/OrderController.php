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
    /**
     * @return array
     * @throws NotFoundHttpException
     */
    public function actionFast()
    {
        if (Yii::$app->request->isPost) {
            $model = new Order(false, ['scenario' => 'short']);
            $model->status = Order::ORDER_FAST;
            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                Yii::$app->session->setFlash('message', 'Ваша заявка принята!');
                return $this->redirect(Yii::$app->request->referrer);
            }
            Yii::$app->session->setFlash('message', current($model->getFirstErrors()));
            return $this->redirect(Yii::$app->request->referrer);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionConfirm()
    {
        if (Yii::$app->request->isPost) {
            $model = new Order(Yii::$app->session['discount']);

            if ($model->load(Yii::$app->request->post()) && $model->save()) {
                $items = $model->setOrderId();

                return $this->render('success', [
                    'model' => $model,
                    'items' => $items
                ]);
            }
            Yii::$app->session->setFlash('message', current($model->getFirstErrors()));
            return $this->redirect(Yii::$app->request->referrer);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
