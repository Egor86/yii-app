<?php

namespace frontend\controllers;

use common\models\Coupon;
use common\models\Item;
use common\models\Order;
use frontend\models\CouponForm;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class CartController extends Controller
{
    public function actionCheckout()
    {
        Yii::$app->cart->checkOut(false);
        $this->redirect(['index']);
    }

    /**
     * Create and add to cart positions
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $post = Yii::$app->request->post('Item');
        $item = Item::findOne($post['id']);
        if ($item) {
            $item_cart_position = $item->getCartPosition([
                'id' => $item->id,
                'size' => $post['sizes']
            ]);

            $item_cart_position->item;
            Yii::$app->cart->create($item_cart_position, $post['quantity']);
            return $this->redirect(['/site/index']);
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelete($id)
    {
        $cart = Yii::$app->cart;

        if ($cart->hasItem($id)) {
            $cart->deleteById($id);
        }
        return $this->redirect('/cart'.Yii::$app->urlManager->suffix);
    }

    public function actionIndex()
    {
        $cart = Yii::$app->cart;
        $products = $cart->getItems();
        $total = $cart->getCost();
        return $this->render('index', [
            'products' => $products,
            'total' => $total,
        ]);
    }

    /**
     * @return array|bool data to update total_sum and total_pay (including discount if present)
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            Yii::$app->response->format = Response::FORMAT_JSON;
            $cart = Yii::$app->cart;
            $item = $cart->items[$post['pk']];
            if ($item && $item->canSetProperty($post['name'])) {
                $item->{$post['name']} = $post['value'];
                $cart->save();
                $response = [
                    'total_sum' => Yii::$app->formatter->asCurrency($cart->getCost()),
                    'total_pay' => Yii::$app->formatter->asCurrency($cart->getCost(true))
                ];
                return $response;
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }


    public function actionView()
    {
        $cart = Yii::$app->cart;
        if (!$cart->getIsEmpty()) {
            $coupon_form = new CouponForm([], Yii::$app->session['discount'] ?? false);
            $order = new Order();

            $dataProvider = new  ArrayDataProvider([
                'allModels' => $cart->items,
                'sort' => false
            ]);

            return $this->render('view', [
                'dataProvider' => $dataProvider,
                'coupon_form' => $coupon_form,
                'order' => $order,
            ]);
        }

        return $this->render('empty_cart');
    }
}
