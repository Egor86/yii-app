<?php

namespace frontend\controllers;

use common\models\Comment;
use Yii;

class CommentController extends \yii\web\Controller
{
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionAdd()
    {
        $model = new Comment(['scenario' => 'add']);

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->save()) {
                // form inputs are valid, do something here
                return true;
            }
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionShow()
    {
        return $this->render('show');
    }

}
