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
        if (Yii::$app->request->isPost) {
            $model = new PreOrder();
            Yii::$app->session->setFlash('message', 'Как только товар появится, мы с вами свяжемся');
            if (!$model->load(Yii::$app->request->post()) || !$model->save()) {
                Yii::$app->session->setFlash('message', current($model->getFirstErrors()));
            }
            return $this->redirect(Yii::$app->request->referrer);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
