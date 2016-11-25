<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Color;
use common\models\ImageStorage;
use common\models\Item;
use Yii;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ItemController extends Controller
{
    /**
     * Finds the Item model based on its primary key value.
     * Finds sizeTableName by parent product category_id
     * Finds same_items by product_id
     * @param $id
     * @return string
     */
//    public function actionView($slug)
//    {
//
//        echo '<pre>';
//        @print_r($slug);
//        echo '</pre>';
//        exit(__FILE__ .': '. __LINE__);
//    }
    public function actionView($slug)
    {
        $model = $this->findModelBySlug($slug);
        $query = new Query();
        $size_table = $query->select('*')
            ->from(Category::findOne($model->product->category_id)->sizeTableName->name)
            ->all();

        $same_items = Item::find()->where(['product_id' => $model->product_id])->all();
        $images = ImageStorage::find()->where(['class' => get_class($model), 'class_item_id' => $model->id])->orderBy('type')->all();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $size_table,
        ]);

        Yii::$app->view->params['seo'] = $model->seo;

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'same_items' => $same_items,
            'images' => $images
        ]);
    }

    /**
     * Finds the Item model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Item the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Item::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelBySlug($slug)
    {
        if (($model = Item::findOne(['slug' => $slug])) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
