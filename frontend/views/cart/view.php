<?php

/* @var $this yii\web\View */
/** @var $coupon_form frontend\models\CouponForm*/
/** @var $order common\models\Order*/

use kartik\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\Pjax;
use yii2mod\editable\EditableColumn;

$this->title = 'Корзина';

/*
 * calling func when changed quantity
 * from @front-web/assets/5fe37ffd/js/bootstrap-editable.js 245 line
 */
$this->registerJs("
var channged_quantity = function(response) {
    if(response) {
        $(\"#total-pay\").text(response['total_pay']);
        $(\"#total-sum\").text(response['total_sum']);
    }
}
", \yii\web\View::POS_HEAD);?>

<?= GridView::widget([
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'striped' => true,
//    'showPageSummary' => true,
    'hover' => true,
    'export' => false,
    'summary' => false,
    'resizableColumns'=>false,
    'columns'=>[
        [
            'class'=>'kartik\grid\SerialColumn',
            'width'=>'5px',
        ],
        [
            'attribute'=>'Name',
            'width'=>'100px',
            'value' => function($model, $key, $index, $widget) {
                return $model->item->name;
            },
            'label' => 'Наименование товара'
        ],
        [
            'attribute'=>'color',
            'width'=>'250px',
            'value'=>function ($model, $key, $index, $widget) {
                return \common\models\Color::findOne($model->item->color)->name;
            },
            'label' => 'Цвет'
        ],
        [
            'attribute' => 'size',
            'value' => function ($model, $key, $index, $widget) {
                return \common\models\Size::findOne($model->size)->value;
            },
            'label' => 'Размер',
        ],
        [
            'attribute' => 'price',
            'value' => function ($model, $key, $index, $widget) {
                if ($model->item->discount_price > 0) {
                    return $model->item->discount_price;
                }
                return $model->item->price;
            },
            'label' => 'Цена',
            'width' => '150px',
            'format' => 'currency',
            'hAlign'=>'right',
            'pageSummary' => 'Всего'
        ],
        [
            'class' => EditableColumn::className(),
            'type' => 'number',
            'url' => ['/cart/update'],
            'editableOptions' => function () {
                return [
                    'min' => 1,
                    'max' => 5,
                ];
            },
            'attribute' => 'quantity',
            'value' => function ($model, $key, $index, $widget) {
                return $model->quantity;
            },
            'label' => 'Количество',
            'options' => ['name' => 'quantity']
        ],
        [
            'class' => 'yii\grid\ActionColumn',
            'template'=>'{delete}',
        ],
    ],
]);

if (!$coupon_form->coupon) {
    echo $this->render('@frontend/views/coupon/_form', [
        'coupon_form' => $coupon_form
    ]);
}

?>
<div class="col-md-3">
    <div class="box" id="order-summary">

        <div class="table-responsive">
            <table class="table">
                <tbody>
                <tr>
                    <td>Суммарная стоимость:</td>
                    <th><span id="total-sum"><?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost())?></span></th>
                </tr>
                <tr>
                    <td>Промокод:</td>
                    <th><span id="discount"><?= Yii::$app->formatter->asCurrency(($coupon_form->coupon ? $coupon_form->coupon->discount : 0))?></span></th>
                </tr>
                <tr>
                    <td>Доставка:</td>
                    <th><?= Yii::$app->formatter->asCurrency(0)?></th>
                </tr>
                <tr class="total">
                    <td>Итого:</td>
                    <th><span id="total-pay"><?= Yii::$app->formatter->asCurrency(Yii::$app->cart->getCost(true))?></span></th>
                </tr>
                </tbody>
            </table>
        </div>

    </div>
</div>

    <div class="order-form">
<!--        --><?php //Pjax::begin(['id' => 'container' , 'enablePushState' => false]); ?>

            <?php $form = ActiveForm::begin(['action' => '/order/confirm'.Yii::$app->urlManager->suffix, 'options' => ['data-pjax' => true ]]); ?>

            <?= $form->field($order, 'coupon_id')->hiddenInput(['id' => 'coupon-id', 'value' => $coupon_form->coupon ? $coupon_form->coupon->id : ''])->label(false) ?>

            <div class="form-group">
                <?= Html::submitButton('Оформить заказ', ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

<!--        --><?php //Pjax::end(); ?>
    </div>