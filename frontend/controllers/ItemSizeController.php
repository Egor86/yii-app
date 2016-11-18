<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Item;
use common\models\ItemSize;
use common\models\Size;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ItemSizeController extends \yii\web\Controller
{
    public function actionCheckAmount()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $response = false;
            if ($item = Item::findOne(['id' => $post['item_id']])) {
                Yii::$app->response->format = Response::FORMAT_HTML;

                $sizes = $item->getSizeTable();

                $item_sizes = ItemSize::find()
                    ->select(['size_id', 'amount'])
                    ->where(['item_id' => $item->id])
                    ->asArray()
                    ->all();

                return $this->renderPartial('_sizes', [
                    'sizes' => $sizes,
                    'item_sizes' => $item_sizes
                ]);
            }
            return $response;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionUnavailableSize()
    {
        if (Yii::$app->request->isAjax) {
            $post = Yii::$app->request->post();
            $response = false;
            if ($item = Item::findOne(['id' => $post['item_id']])) {

                $unavailable_sizes = ItemSize::getUnavailableSize($item);

                if (!$unavailable_sizes) {
                    return $response;
                }

                Yii::$app->response->format = Response::FORMAT_HTML;
                return $this->renderPartial('_unavailable_size_form', [
                    'item' => $item,
                    'unavailable_sizes' => $unavailable_sizes
                ]);
            }
            return $response;
        }
        throw new NotFoundHttpException('The requested page does not exist.');        
    }

}
