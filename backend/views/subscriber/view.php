<?php

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

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'name',
            'email:email',
            'phone',
            'created_at:datetime',
            'updated_at:datetime',
            [
                'attribute' => 'coupon',
                'value' => ($coupon = \common\models\Coupon::findOne(['subscriber_id' => $model->id])) ?
                    $coupon->coupon_code : '--'
            ],
            [
                'attribute' => 'couponUsingStatus',
                'value' => $coupon ? $coupon->using_status ? "Да" : 'Нет' : '--'
            ],
            [
                'attribute' => 'mail_chimp_status',
                'value' => Subscriber::getMailChimpStatus()[$model->mail_chimp_status]
            ],
        ],
    ]) ?>

</div>
