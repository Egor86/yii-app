<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Product;
use common\models\ProductColor;
use common\models\Size;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $query = new Query();
        $rows = $query->select('*')
            ->from(Category::findOne($model->category_id)->sizeTableName->name)
            ->all();

        $dataProvider = new ArrayDataProvider([
            'allModels' => $rows,
        ]);

        return $this->render('view', [
            'model' => $this->findModel($id),
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
