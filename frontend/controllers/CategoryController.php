<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Item;
use common\models\Product;
use frontend\models\ItemSearch;
use Yii;
use yii\data\Sort;
use yii\web\NotFoundHttpException;

class CategoryController extends \yii\web\Controller
{
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);

//        echo '<pre>';
//        @print_r(Yii::$app->request->queryParams);
//        echo '</pre>';
//        exit(__FILE__ .': '. __LINE__);
        $itemSearch = new ItemSearch();
        $dataProvider = $itemSearch->search(Yii::$app->request->queryParams, $model->id);

        return $this->render('view', [
            'itemSearch' => $itemSearch,
            'dataProvider' => $dataProvider,
            'model' => $model
        ]);
    }

    protected function findModelBySlug($slug)
    {
        if (($model = Category::findOne(['slug' => $slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
