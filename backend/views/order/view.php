<?php

use common\models\Coupon;
use common\models\Order;
use kartik\detail\DetailView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\MaskedInput;

/* @var $this yii\web\View */
/* @var $model common\models\Order */
/* @var $product common\models\Product */
/* @var $coupon_form common\models\CouponForm */

$this->title = 'Заказ # ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Orders', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
/*
 * func changeCost calling in /backend/web/assets/------/js/bootstrap-editable.js
 * on 245 line, for changing Order total_cost
 */
$this->registerJs('
function changeCost(response){
    if (response) {
        $("#total-sum").text(response.total_sum);
    }
}
', \yii\web\View::POS_HEAD);

?>
<div class="order-view">

    <div><h4>Изменить статус заказа</h4></div>
    <p>
        <?php if ($model->status == Order::ORDER_FAST) : ?>
            <?= Html::button(Order::getStatus()[Order::ORDER_FAST], [
                'class' => 'btn btn-success',
                'data-toggle' => 'tooltip',
            ]) ?>
        <?php endif;?>
        <?= Html::a(Order::getStatus()[Order::ORDER_NEW], ['change-status', 'id' => $model->id, 'status' => Order::ORDER_NEW], [
            'class' => $model->status == Order::ORDER_NEW ? 'btn btn-success' : 'btn btn-primary',
            'data-toggle' => 'tooltip',
        ]) ?>
        <?= Html::a(Order::getStatus()[Order::ORDER_PROCESSED], ['change-status', 'id' => $model->id, 'status' => Order::ORDER_PROCESSED], [
            'class' => $model->status == Order::ORDER_PROCESSED ? 'btn btn-success' : 'btn btn-primary',
            'data-toggle' => 'tooltip',
        ]) ?>
        <?= Html::a(Order::getStatus()[Order::ORDER_REVOKED], ['change-status', 'id' => $model->id, 'status' => Order::ORDER_REVOKED], [
            'class' => $model->status == Order::ORDER_REVOKED ? 'btn btn-success' : 'btn btn-primary',
            'data-toggle' => 'tooltip',
        ]) ?>
        <?= Html::a(Order::getStatus()[Order::ORDER_DONE], ['change-status', 'id' => $model->id, 'status' => Order::ORDER_DONE], [
            'class' => $model->status == Order::ORDER_DONE ? 'btn btn-success' : 'btn btn-primary',
            'data-toggle' => 'tooltip',
        ]) ?>

    </p>

    <?php if (!$model->coupon_id) : ?>
        <?= $this->render('_coupon_form', [
            'coupon_form' => $coupon_form,
            'model' => $model
        ])?>
    <?php endif; ?>

    <?= DetailView::widget([
        'model' => $model,
        'condensed'=>true,
        'hover'=>true,
        'formOptions' => [
            'action' => Url::to('update?id='.$model->id),
        ],
        'mode'=>DetailView::MODE_VIEW,
        'panel'=>[
            'heading'=>'Заказ # ' . $model->id,
            'type'=>DetailView::TYPE_INFO,
        ],
        'buttons1' => '{update}',
        'attributes' => [
            [
                'attribute' => 'fullName',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'name', ['template' => "{label}{input}{error}",]) . '<br>' .
                    $form->field($model, 'surname', ['template' => "{label}{input}{error}",]);
                },
                'valueColOptions'=>['style'=>'width:70%'],
            ],
            [
                'attribute' => 'fullAddress',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'organization_name', ['template' => "{label}{input}{error}",]) . '<br>' .
                    $form->field($model, 'address', ['template' => "{label}{input}{error}",]) . '<br>' .
                    $form->field($model, 'city', ['template' => "{label}{input}{error}",]) . '<br>' .
                    $form->field($model, 'region', ['template' => "{label}{input}{error}",]) . '<br>' .
                    $form->field($model, 'country', ['template' => "{label}{input}{error}",]) . '<br>' .
                    $form->field($model, 'post_index', ['template' => "{label}{input}{error}",]);
                },
                'valueColOptions'=>['style'=>'width:70%'],
            ],
            [
                'attribute' => 'phone',
                'displayOnly' => $model->coupon_id ? true : false,
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'phone')->textInput(['value' => $model->phone])->widget(MaskedInput::className(),[
                        'name' => 'phone',
                        'mask' => '(999) 999-99-99',
                        'clientOptions' => [
                            'removeMaskOnSubmit' => true,
                        ]]);
                },
            ],
            [
                'attribute' => 'email',
                'displayOnly' => $model->coupon_id ? true : false,
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'email')->textInput(['value' => $model->email])->widget(MaskedInput::className(), [
                        'name' => 'email',
                        'clientOptions' => ['alias' =>  'email']
                    ]);
                },
            ],
            [
                'attribute' => 'delivery_date',
                'format' => 'date',
                'updateMarkup' => function($form, $widget) {
                    $model = $widget->model;
                    return $form->field($model, 'delivery_date')->widget(\yii\jui\DatePicker::className(), [
                        'dateFormat' => 'yyyy-MM-dd',
                        'language' => 'ru'
                    ]);
                },
            ],
            [
                'attribute' => 'coupon_id',
                'label' => 'Купон',
                'value' => $model->coupon_id ? $model->coupon->coupon_code . ' (Получатель купона:   ' . $model->coupon->subscriber->email . ',   ' . $model->coupon->subscriber->phone . ')' : '',
                'valueColOptions'=>['style'=>'width:70%'],
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'attribute' => 'status',
                'value' => Order::getStatus()[$model->status],
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'attribute' => 'created_at',
                'format' => 'datetime',
                'rowOptions' => ['class'=>'kv-edit-hidden'],
            ],
            [
                'attribute' => 'total_cost',
                'format' => 'currency',
                'rowOptions' => ['class'=>'kv-edit-hidden'],
                'valueColOptions' => ['id' => 'total-sum']
            ],
        ],
    ]) ?>

</div>

<div>
    <?= $this->render('_order_detail', [
        'dataProvider' => $dataProvider
    ])?>

    <?= $this->render( '_add_item', [
        'product'=> $product,
        'model' => $model
    ]); ?>
</div>

