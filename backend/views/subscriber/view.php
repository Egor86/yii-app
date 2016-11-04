<?php

use common\models\Coupon;
use common\models\Subscriber;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Subscriber */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Subscribers', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="subscriber-view">

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email',
            'phone',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'coupon',
                'value' => ($coupon = Coupon::findOne(['subscriber_id' => $model->id])) ?
                    $coupon->coupon_code : null
            ],
            [
                'attribute' => 'couponUsingStatus',
                'value' => $coupon ? $coupon->using_status ? "Да" : 'Нет' : null
            ],
            [
                'attribute' => 'mail_chimp_status',
                'value' => Subscriber::getMailChimpStatus()[$model->mail_chimp_status]
            ],
        ],
    ]) ?>

</div>
