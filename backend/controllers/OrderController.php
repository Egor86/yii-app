<?php

namespace backend\controllers;

use backend\models\search\OrderSearch;
use common\models\Coupon;
use common\models\CouponForm;
use common\models\Item;
use common\models\PreOrder;
use common\models\Product;
use Yii;
use common\models\Order;
use yii\data\ArrayDataProvider;
use yii\filters\AccessControl;
use yii\web\ConflictHttpException;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Response;

/**
 * OrderController implements the CRUD actions for Order model.
 */
class OrderController extends Controller
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
     * Lists all Order models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all Order models.
     * @return mixed
     */
    public function actionArchive()
    {
        $searchModel = new OrderSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, true);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Order model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        $model = $this->findModel($id);
        $items = $model->value ? $model->setOrderId() : [];    // base64_decode and unserialize Order::value,
                                                               // concat Order::id with each Order value key
                                                                // if Order::ORDER_FAST and item was not added, $model->value is empty
        $product = new Product();
        $coupon_form = new CouponForm();
        $dataProvider = new ArrayDataProvider([
            'allModels' => $items,
            'sort' => false,
        ]);

        return $this->render('view', [
            'model' => $model,
            'dataProvider' => $dataProvider,
            'product' => $product,
            'coupon_form' => $coupon_form
        ]);
    }

    /**
     * Creates a new Order model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
//    public function actionCreateShort($pre_order_id)
//    {
//        $pre_order = PreOrder::findOne($pre_order_id);
//
//        if (!$pre_order) {
//            throw new NotFoundHttpException('The requested page does not exist.');
//        }
//
//        $model = new Order(false, ['scenario' => 'short']);
//
//        if ($model->load(Yii::$app->request->post()) && $model->save()) {
//            return $this->redirect(['view', 'id' => $model->id]);
//        } else {
//            return $this->render('create', [
//                'model' => $model,
//            ]);
//        }
//    }

    /**
     * @param $id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return array
     * @throws ConflictHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdateValue()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $id = explode('_', $post['pk']);
            $model = $this->findModel($id[0]);
            $item = $model->getValue()[$id[1]];
            if ($item && $item->canSetProperty($post['name'])) {
                $item->{$post['name']} = $post['value'];
                if ($model->setValue($id[1], $item)) {
                    Yii::$app->response->format = Response::FORMAT_JSON;
                    $response = [
                        'total_sum' => Yii::$app->formatter->asCurrency($model->total_cost),
                    ];
                    return $response;
                }
                throw new ConflictHttpException('Товар данного размера уже существует');
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionAddItem($id)
    {
        $model = $this->findModel($id);
        $post = Yii::$app->request->post('Item');

        if ($item = Item::findOne($post['id'])) {
            $item_cart_position = $item->getCartPosition([
                'id' => $item->id,
                'size' => $post['sizes'],
                'quantity' => $post['quantity']
            ]);
            $item_cart_position->item;
            $model->setValue($item_cart_position->getId(), $item_cart_position);
        }

        return $this->redirect(['view', 'id' => $id]);
    }
    /**
     * Deletes ItemCartPosition from Order::value by item id
     * @param $id
     * @param $item_id
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionDeleteItem($id, $item_id)
    {
        $model = $this->findModel($id);

        if ($model->deleteItem($item_id)) {

            return $this->redirect([
                'view',
                'id' => $id
            ]);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Deletes an existing Order model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionChangeStatus($id, $status)
    {
        $model = $this->findModel($id);
        $model->status = $status;

        if ($model->save(false)) {
            if ($model->status == Order::ORDER_REVOKED || $model->status == Order::ORDER_DONE) {
                $model->trigger(Order::EVENT_CHANGE_STATUS);
                return $this->redirect('index');
            }
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->redirect([
            'view',
            'id' => $id
        ]);
    }

    /**
     * Finds the Order model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Order the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Order::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }
}
