<?php

namespace frontend\controllers;

use common\models\Order;
use common\models\Product;
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
        $post = Yii::$app->request->post('Product');
        $product = Product::findOne($post['id']);
        if ($product) {
            $product_cart_position = $product->getCartPosition([
                'id' => $product->id,
                'color' => $post['colors'],
                'size' => $post['sizes']
            ]);

            $product_cart_position->product;
            Yii::$app->cart->create($product_cart_position, $post['quantity']);
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
        return $this->redirect('view'.Yii::$app->urlManager->suffix);
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
                return true;
            }
        }
        return false;
    }


    public function actionView()
    {
        $cart = Yii::$app->cart;
        $dataProvider = new  ArrayDataProvider([
            'allModels' => $cart->items,
            'sort' => false
        ]);
        return $this->render('view', [
            'dataProvider' => $dataProvider
        ]);
    }
}
