<?php

namespace frontend\controllers;

use common\models\Category;
use common\models\Item;
use common\models\ItemSize;
use common\models\Size;
use yii\web\NotFoundHttpException;
use yii\web\Response;

class ItemSizeController extends \yii\web\Controller
{
    public function actionCheckAmount()
    {
        if (\Yii::$app->request->isAjax) {
            $post = \Yii::$app->request->post();
            if ($item = Item::findOne(['id' => $post['item_id']])) {
                \Yii::$app->response->format = Response::FORMAT_HTML;

                $sizes = Size::find()->where(['size_table_name_id' => Category::findOne(['id' => $item->product->category_id])->size_table_name_id])->asArray()->all();
                $item_sizes = ItemSize::find()->select(['size_id', 'amount'])->where(['item_id' => $item->id])->asArray()->all();

                return $this->renderPartial('_sizes', [
                    'sizes' => $sizes,
                    'item_sizes' => $item_sizes
                ]);
            }
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
