<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Item;
use common\models\Product;
use Yii;
use yii\data\Sort;
use yii\web\NotFoundHttpException;

class CategoryController extends \yii\web\Controller
{
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);

        $sort = new Sort([
            'attributes' => [
                'created_at' => [
                    'default' => SORT_DESC,
                    'label' => 'Сначала новые',
                ],
                'price' => [
                    'default' => SORT_DESC,
                    'label' => 'Сначала дорогие',
                ],
                'price_low' => [
                    'asc' => ['price' => SORT_ASC],
                    'desc' => ['price' => SORT_DESC],
                    'label' => 'Сначала дешевые',
                ],
                'discount_price' => [
                    'default' => SORT_DESC,
                    'label' => 'Только со скидкой',
                ],
            ],
        ]);


        $params = Yii::$app->request->queryParams;

        $item = Item::find()->where([
                'in',
                'product_id',
                Product::find()->where(['category_id' => $model->id])->asArray()->column()])
            ->orderBy($sort->orders)->limit($params['limit'] ?? Item::ITEM_VIEW_LIMIT)->all();

        return $this->render('view', [
            'item' => $item,
            'sort' => $sort,
        ]);
    }

    public function actionFilter($slug)
    {
        return $this->redirect('/');
//        echo '<pre>';
//        @print_r(Yii::$app->request->queryParams);
//        echo '</pre>';
//        exit(__FILE__ .': '. __LINE__);
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
