<?php

namespace backend\controllers;

use backend\models\Model;
use common\models\Product;
use common\models\ProductColorSize;
use Yii;
use common\models\ProductColor;
use yii\data\ActiveDataProvider;
use yii\db\Exception;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ProductColorController implements the CRUD actions for ProductColor model.
 */
class ProductColorController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ProductColor models.
     * @return mixed
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => ProductColor::find(),
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ProductColor model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new ProductColor model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($product_id)
    {
        $product = Product::findOne($product_id);
        $models = [new ProductColor()];
        $product_color_size = [[new ProductColorSize()]];

        if (Yii::$app->request->post()) {
            if ($product){
                $models = Model::createMultiple(ProductColor::classname());

                Model::loadMultiple($models, Yii::$app->request->post());

                $valid = Model::validateMultiple($models);
                $post_product_color_size = Yii::$app->request->post('ProductColorSize');

                foreach ($post_product_color_size as $indexProductColor => $productColorSizes){

                    foreach ($productColorSizes as $indexProductColorSize => $productColorSize){
                        $data['ProductColorSize'] = $productColorSize;
                        $modelProductColorSize = new ProductColorSize();
                        $modelProductColorSize->load($data);
                        $models_product_color_size[$indexProductColor][$indexProductColorSize] = $modelProductColorSize;
                    }
                }

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        foreach ($models as $models_key => $model) {
                            $flag = $model->save(false);
                            if (! ($flag)) {
                                $transaction->rollBack();
                                break;
                            }

                            foreach ($models_product_color_size[$models_key] as  $productColorSize){
                                $productColorSize->product_color_id = $model->id;
                                if (!($flag = $productColorSize->save())){
                                    break;
                                }
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['product/view', 'id' => $product->id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }
            throw new NotFoundHttpException('The requested product does not exist.');
        }

        return $this->render('create', [
            'product' => $product,
            'model' => $models ,
            'product_color_size' => $product_color_size
        ]);
    }

    /**
     * Updates an existing ProductColor model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($product_id)
    {
        if ($product = Product::findOne($product_id)){
            $models = ProductColor::findAll(['product_id' => $product_id]);
            $product_color_size = [];
            $old_product_color_size = [];

            if (!empty($models)) {
                foreach ($models as $indexModel => $modelProductColor) {
                    $product_color_sizes = $modelProductColor->productColorSizes;
                    $product_color_size[$indexModel] = $product_color_sizes;
                    $old_product_color_size = ArrayHelper::merge(
                        ArrayHelper::index($product_color_sizes, 'id'), $old_product_color_size);
                }
            }

            if ($post = Yii::$app->request->post()) {
                $oldModelIDs = ArrayHelper::map($models, 'id', 'id');
                $models = Model::createMultiple(ProductColor::classname(), $models);
                Model::loadMultiple($models, $post);
                $deletedModelIDs = array_diff($oldModelIDs, array_filter(ArrayHelper::map($models, 'id', 'id')));
                $valid = Model::validateMultiple($models);

                $product_color_size_ids =[];
                $post_product_color_size = Yii::$app->request->post('ProductColorSize');

                foreach ($post_product_color_size as $indexProductColor => $productColorSizes){
                    $product_color_size_ids =ArrayHelper::merge(
                        $product_color_size_ids, array_filter(
                            ArrayHelper::getColumn($productColorSizes, 'id')));

                    foreach ($productColorSizes as $indexProductColorSize => $productColorSize){
                        $data['ProductColorSize'] = $productColorSize;
                        $modelProductColorSize = (isset($productColorSize['id']) &&
                            isset($old_product_color_size[$productColorSize['id']]))
                            ? $old_product_color_size[$productColorSize['id']] : new ProductColorSize();
                        $modelProductColorSize->load($data);
                        $models_product_color_size[$indexProductColor][$indexProductColorSize] = $modelProductColorSize;
                    }
                }

                $old_product_color_size_ids = ArrayHelper::getColumn($old_product_color_size, 'id');
                $deletedProductColorSizeIDs = array_diff($old_product_color_size_ids, $product_color_size_ids);

                if ($valid) {
                    $transaction = Yii::$app->db->beginTransaction();
                    try {
                        if (!empty($deletedProductColorSizeIDs)) {
                            ProductColorSize::deleteAll(['id' => $deletedProductColorSizeIDs]);
                        }

                        if (! empty($deletedModelIDs)) {
                            ProductColor::deleteAll(['id' => $deletedModelIDs]);
                        }

                        foreach ($models as $model_key => $model) {

                            if (!($flag = $model->save(false))) {
                                break;
                            }

                            if (isset($models_product_color_size[$model_key]) &&
                                is_array($models_product_color_size[$model_key]))
                            {
                                foreach ($models_product_color_size[$model_key] as $productColorSize) {
                                    $productColorSize->product_color_id = $model->id;
                                    if (!($flag = $productColorSize->save())) {
                                        throw new Exception('Указанные размеры уже созданы');
                                    }
                                }
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['/product/view', 'id' => $product->id]);
                        } else {
                            $transaction->rollBack();
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                        return $e->getMessage();
                    }
                }
            }
            return $this->render('update', [
                'product' => $product,
                'model' => empty($models) ? [new ProductColor] : $models ,
                'product_color_size' => empty($product_color_size) ?
                    [[new ProductColorSize]] : $product_color_size ,
            ]);
        }

        return $this->redirect(['/product/index']);
    }

    /**
     * Deletes an existing ProductColor model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
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
