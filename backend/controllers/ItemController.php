<?php

namespace backend\controllers;

use backend\models\Model;
use backend\models\MultipleImageForm;
use common\models\ImageStorage;
use common\models\ItemSize;
use common\models\Product;
use Exception;
use Yii;
use common\models\Item;
use backend\models\search\ItemSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ItemController implements the CRUD actions for Item model.
 */
class ItemController extends Controller
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
     * Lists all Item models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Item model.
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
     * Creates a new Item model and .ItemSize models
     * If creation is successful, the browser will be redirected to the image-adding page.
     * @return mixed
     */
    public function actionCreate($product_id)
    {
        $product = Product::findOne($product_id);
        $model = new Item();
        $item_sizes = [new ItemSize()];
        $image_storages = [new ImageStorage()];

        if ($model->load(Yii::$app->request->post())) {
            $item_sizes = Model::createMultiple(ItemSize::className());
            Model::loadMultiple($item_sizes, Yii::$app->request->post());

            $valid = $model->validate();
            $valid = Model::validateMultiple($item_sizes);

            if ($valid) {
                $transaction = \Yii::$app->db->beginTransaction();
                try {
                    if ($flag = $model->save(false)) {
                        foreach ($item_sizes as $model_item_size) {
                            $model_item_size->item_id = $model->id;
                            if (! ($flag = $model_item_size->save(false))) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                        $image_storages = Model::createMultiple(ImageStorage::className());
                        Model::loadMultiple($image_storages, Yii::$app->request->post());

                        foreach ($image_storages as $image) {
                            $flag = $image->uploadImages(self::class, $model->id, 'product_images');
                            if (! ($flag)) {
                                $transaction->rollBack();
                                break;
                            }
                        }
                    }
                    if ($flag) {
                        $transaction->commit();
                        return $this->redirect(['/product/view', 'id' => $product->id]);
                    }
                } catch (Exception $e) {
                    $transaction->rollBack();
                }
            }
        }

        return $this->render('create', [
            'product' => $product,
            'model' => $model ,
            'item_sizes' => $item_sizes,
            'image_storages' => [new ImageStorage()]
        ]);
    }

    /**
     * Updates an existing Item model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Deletes an existing Item model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
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
}
