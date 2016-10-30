<?php

namespace backend\controllers;

use backend\models\MultipleImageForm;
use backend\models\search\ProductColorSearch;
use backend\models\search\ProductSearch;
use backend\models\VideoForm;
use common\models\Item;
use common\models\ItemSize;
use common\models\ProductColor;
use common\models\ProductColorSize;
use Exception;
use Yii;
use common\models\Product;
use yii\base\Model;
use yii\bootstrap\Modal;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\db\Query;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\HttpException;
use yii\web\Response;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
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
                        'actions' => ['index', 'view', 'create', 'update', 'delete', 'add-images', 'delete-video'],
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

    public function actions()
    {
        return [
            'sorting' => [
                'class' => \kotchuprik\sortable\actions\Sorting::className(),
                'query' => Product::find(),
                'orderAttribute' => 'sort_by'

            ]
        ];
    }

    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
//        $product_color_ids = [];
//        $product_colors = Item::find()->select('id')
//            ->where('product_id='.$model->id)->asArray()->all();
//
//        for ($i = 0; $i < count($product_colors); $i++){
//            $product_color_ids[] = $product_colors[$i]['id'];
//        }
//
//        $query = ItemSize::find()
//            ->where(['item_id' => $product_color_ids]);
//
//        $dataProvider = new ActiveDataProvider([
//            'query' => $query,
//            'sort' => false
//        ]);
        $items = Item::findAll(['product_id' => $model->id]);

        return $this->render('view', [
            'model' => $model,
            'items' => $items
//            'dataProvider'=> $dataProvider,
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Product();
        $video_form = new VideoForm();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            $model->video_id = $video_form->uploadVideo(get_class($model), $model->id);

            if (!$model->video_id || !$model->save()){
                $this->findModel($model->id)->delete();
                return $this->render('create', [
                    'model' => $model,
                    'video_form' => $video_form,
                ]);
            }
            return $this->redirect(['item/create', 'product_id' => $model->id]);
        }

        return $this->render('create', [
            'model' => $model,
            'video_form' => $video_form,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $video_form = new VideoForm;

        if ($model->load(Yii::$app->request->post()) && $model->save(false)) {

            $video_form->load(Yii::$app->request->post());
            $video_id = $video_form->uploadVideo(get_class($model), $model->id);
            if ($video_id) {
                $model->video_id = $video_id;
                if(!$model->save()){
                    return $this->render('update', [
                        'model' => $model,
                        'video_form' => $video_form,
                    ]);
                }
            }
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                'model' => $model,
                'video_form' => $video_form,
            ]);
        }
    }

    /**
     * @param $id
     * @return string
     * @deprecated not usage
     */
    public function actionAddImages($id){

        $model = $this->findModel($id);
        $multiple_form = new MultipleImageForm();

        if (Yii::$app->request->isAjax) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            if ($multiple_form->uploadImages(get_class($model), $model->id)) {
                return 'Images were saved';
            } else {
                return 'Images were not saved';
            }
        }
        return $this->render('img_upload', [
            'model' => $model,
            'multiple_form' => $multiple_form,
        ]);
    }

    public function actionDeleteVideo($id)
    {
        $model = $this->findModel($id);
        $model->video ? $model->video->delete() : false;
        $model->video_id = null;
        $model->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, echo success.
     * @throws HttpException
     */
    public function actionDelete()
    {
        $post = Yii::$app->request->post();
        if (Yii::$app->request->isAjax) {
            $id = $post['id'];
            if ($this->findModel($id)->delete()) {
                echo Json::encode([
                    'success' => true,
                    'messages' => [
                        'kv-detail-info' => 'Товар # ' . $id . ' был удален. <a href="' .
                            Url::to(['/product']) . '" class="btn btn-sm btn-info">' .
                            '<i class="glyphicon glyphicon-hand-right"></i>  Вернуться к товарам</a>.'
                    ]
                ]);
            } else {
                echo Json::encode([
                    'success' => false,
                    'messages' => [
                        'kv-detail-error' => 'Товар # ' . $id . ' не был удален, проверьте, возможно это родительский товар.'
                    ]
                ]);
            }
            return;
        }
        throw new HttpException("You are not allowed to do this operation. Contact the administrator.");
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

