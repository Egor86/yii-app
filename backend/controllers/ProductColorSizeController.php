<?php

namespace backend\controllers;

use common\models\ProductColorSize;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProductColorSizeController extends \yii\web\Controller
{
    public function actionDelete()
    {
        if (Yii::$app->request->isAjax){

            Yii::$app->response->format = Response::FORMAT_JSON;
            $model = $this->findModel(Yii::$app->request->post('id'));
            if (!$model){
                return false;
            }

            if ($model->delete()){
                return true;
            }
        }

        return false;
    }

    protected function findModel($id)
    {
        if (($model = ProductColorSize::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
