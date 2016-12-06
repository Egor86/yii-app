<?php

namespace frontend\controllers;

use common\models\Coupon;
use common\models\CouponForm;
use common\models\Item;
use common\models\Order;
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
        if (Yii::$app->session['discount']) {
            $coupon = Coupon::findOne(Yii::$app->session['discount']);
            if ($coupon && Yii::$app->session->remove('discount')) {
                $coupon->using_status = Coupon::UNUSED;
                $coupon->save(false);
            }
        }
        $this->redirect(Yii::$app->getHomeUrl());
    }

    /**
     * Create and add to cart positions
     * @return Response
     * @throws NotFoundHttpException
     */
    public function actionCreate()
    {
        $post = Yii::$app->request->post('Item');

        if ($post['id'] && $post['quantity'] && $post['sizes']) {
            $item = Item::findOne($post['id']);
            if ($item && !$item->isDeleted) {
                $item_cart_position = $item->getCartPosition([
                    'id' => $item->id,
                    'size' => $post['sizes']
                ]);

                $item_cart_position->item;  // add Item model to ItemCartPosition _item property
                Yii::$app->cart->create($item_cart_position, $post['quantity']);
                return $this->redirect(Yii::$app->request->getReferrer());
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    public function actionDelete($id, $slug = false)
    {
        $cart = Yii::$app->cart;

        if ($cart->hasItem($id)) {
            $cart->deleteById($id);
        }
        if (!$slug) {
            return $this->redirect(Yii::$app->request->getReferrer());
        }
        return $this->redirect(['/item/view', 'slug' => $slug]);
    }

//    public function actionIndex()
//    {
//        $cart = Yii::$app->cart;
//        $products = $cart->getItems();
//        $total = $cart->getCost();
//        return $this->render('index', [
//            'products' => $products,
//            'total' => $total,
//        ]);
//    }

    public function actionUpdate()
    {
        if (Yii::$app->request->isPost) {
            $post = Yii::$app->request->post();
            $cart = Yii::$app->cart;
            $item = $cart->getItemById($post['pk']);
            if ($item && $item->canSetProperty($post['name'])) {
                $item->{'set'.$post['name']}($post['value']);
                $cart->save();
            }
            return $this->redirect(['view']);
        }
        return $this->redirect(Yii::$app->getHomeUrl());
    }

//    public function actionPreView()
//    {
//        if (Yii::$app->request->isAjax) {
//            $cart = Yii::$app->cart;
//            $response['success'] = false;
//            if (!$cart->getIsEmpty()) {
//                Yii::$app->response->format = Response::FORMAT_HTML;
//                $response['success'] = true;
//                return $this->renderPartial([
//                    '_pre_view',
//                    'items' => $cart->items
//                ]);
//            }
//            $response['error'] = "Корзина пуста";
//            return $response;
//        }
//        throw new NotFoundHttpException('The requested page does not exist.');
//    }

    public function actionView()
    {
        $cart = Yii::$app->cart;
        if (!$cart->getIsEmpty()) {
            $coupon_form = new CouponForm([], Yii::$app->session['discount']);

            return $this->render('view', [
                'items' => $cart->items,
                'coupon_form' => $coupon_form,
            ]);
        }
        Yii::$app->session->setFlash('message', 'ВАША КОРЗИНА ПУСТА');
        return $this->redirect(Yii::$app->homeUrl);
    }
}
