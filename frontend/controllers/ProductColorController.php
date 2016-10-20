<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Product;
use common\models\ProductColor;
use common\models\ProductColorSize;
use common\models\Size;
use yii\i18n\Formatter;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ProductColorController extends \yii\web\Controller
{
    public function actionGetSize()
    {
        if (\Yii::$app->request->isAjax) {
            \Yii::$app->response->format = Response::FORMAT_HTML;
            $post = \Yii::$app->request->post();

            $model = ProductColor::findOne(['product_id' => $post['product_id'], 'color_id' => $post['color_id']]);
            $category = Category::find()->viaTable(Product::tableName(), ['id' => $model->product_id])->one();
            $sizes = Size::find()->where(['size_table_name_id' => $category->size_table_name_id])->asArray()->all();
            $color_sizes = $model->sizes;

            $template = $this->renderPartial('_sizes', [
                'sizes' => $sizes,
                'color_sizes' =>  $color_sizes
            ]);
            return $template;
        }
        return false;
    }

    /**
     * Finds the ProductColor model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ProductColor the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ProductColor::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
