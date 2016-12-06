<?php

namespace frontend\controllers;

use common\models\Page;
use Yii;
use yii\web\NotFoundHttpException;

class PageController extends \yii\web\Controller
{
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);

        Yii::$app->view->params['seo'] = $model->seo;
        if ($model->slug == 'contacts') {
            return $this->render('//site/contact', ['model' => $model]);
        }
        return $this->render('view', ['model' => $model]);
    }

    protected function findModelBySlug($slug)
    {
        if (($model = Page::findOne(['slug' => $slug])) !== null && $model->status == Page::PUBLISHED) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
