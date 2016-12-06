<?php

namespace backend\controllers;

use backend\models\Model;
use common\models\Item;
use Exception;
use Yii;
use common\models\ItemSize;
use backend\models\search\ItemSizerSearch;
use yii\filters\AccessControl;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * ItemSizeController implements the CRUD actions for ItemSize model.
 */
class ItemSizeController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ItemSize models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ItemSizerSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single ItemSize model.
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
     * Creates a new ItemSize model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new ItemSize();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('create', [
                'model' => $model,
            ]);
        }
    }

    /**
     * @param $item_id
     * @return string|Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($item_id)
    {
        $item = Item::findOne(['id' => $item_id, 'isDeleted' => false]);
        if ($item) {
            $models = ItemSize::findAll(['item_id' => $item_id]);
            if (Yii::$app->request->post()) {
                $oldIDs = ArrayHelper::map($models, 'id', 'id');
                $models = Model::createMultiple(ItemSize::classname(), $models);
                Model::loadMultiple($models, Yii::$app->request->post());
                $deletedIDs = array_diff($oldIDs, array_filter(ArrayHelper::map($models, 'id', 'id')));

                // validate all models
                $valid = true;

                if ($valid) {
                    $transaction = \Yii::$app->db->beginTransaction();
                    try {
                        if (!empty($deletedIDs)) {
                            ItemSize::deleteAll(['id' => $deletedIDs]);
                        }

                        foreach ($models as $model) {
                            $model->item_id = $item->id;
                            if (! ($flag = $model->save())) {
                                $transaction->rollBack();
                                break;
                            }
                        }

                        if ($flag) {
                            $transaction->commit();
                            return $this->redirect(['/item/view', 'id' => $item->id]);
                        }
                    } catch (Exception $e) {
                        $transaction->rollBack();
                    }
                }
            }

            return $this->render('update', [
                'item' => $item,
                'models' => empty($models) ? [new ItemSize()] : $models,
            ]);
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return bool
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
     * Finds the ItemSize model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ItemSize the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = ItemSize::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
