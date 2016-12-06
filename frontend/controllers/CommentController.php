<?php

namespace frontend\controllers;

use common\models\Comment;
use Yii;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CommentController extends \yii\web\Controller
{
    public function actionAdd()
    {
        $model = new Comment();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
                return $this->redirect(Yii::$app->request->getReferrer());
        }

        return $this->render('add', [
            'model' => $model,
        ]);
    }

    public function actionMore()
    {
        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_HTML;
            $post = Yii::$app->request->post();
            $comments = Comment::find()
                ->where(['item_id' => $post['item_id'], 'agree' => true])
                ->limit(3)
                ->offset($post['offset'])->all();
            if (empty($comments)) {
                return false;
            }
            $template = $this->renderPartial('_comments', [
                'comments' => $comments
            ]);
            return $template;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
