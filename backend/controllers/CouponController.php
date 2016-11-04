<?php

namespace backend\controllers;

use common\models\CouponForm;
use common\models\Order;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CouponController extends \yii\web\Controller
{
    public function actionCheck()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $coupon_form = new CouponForm();
            $response['success'] = false;
            if ($coupon_form->load(Yii::$app->request->post()) && $coupon_form->validate()) {
                $order = Order::findOne($coupon_form->order_id);
                if ($order) {
                    $response['success'] = true;
                    $order->coupon_id = $coupon_form->coupon->id;
                    $order->total_cost = max(0, $order->total_cost - $coupon_form->coupon->discount);
                    $order->save(false);
                    return $response;
                }
                $response['error'] = 'Обновите страницу и попробуйте снова';
                return $response;
            }
            $response['error'] = $coupon_form->getFirstErrors()['coupon_code'];
            return $response;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
