<?php
/**
 * Created by PhpStorm.
 * User: egor
 * Date: 27.10.16
 * Time: 17:07
 */

namespace frontend\controllers;

use common\models\CouponForm;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class CouponController extends Controller
{
    public function actionVerify()
    {
        if (\Yii::$app->request->isPjax) {
            $coupon_form = new CouponForm();
            if ($coupon_form->load(Yii::$app->request->post()) && $coupon_form->validate()) {
                $session = Yii::$app->session;
                $session['discount'] = $coupon_form->coupon->id;
                return $this->renderPartial('_success', [
                    'coupon_form' => $coupon_form,
                ]);
            }

            return $this->renderPartial('_form', [
                'coupon_form' => $coupon_form
            ]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }
}