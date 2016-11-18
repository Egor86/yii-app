<?php

use common\models\Category;
use common\models\Item;
use kartik\depdrop\DepDrop;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $product common\models\Product*/
/* @var $model common\models\Order */
/* @var $this yii\web\View */

$item = new Item();
?>
<p>
<h4><span class="glyphicon glyphicon-plus" style="color: #3c8dbc"></span><a class="dashed-link collapsed" data-toggle="collapse" href="#add-item" aria-expanded="false" aria-controls="add-item"> Добавить товар</a></h4>
</p>
<div class="collapse" id="add-item">
<?php $form = ActiveForm::begin(['action' => '/admin/order/add-item?id='.$model->id]);?>

<?= $form->field($product, 'category_id', ['enableClientValidation' => false])->widget(Select2::classname(), [
    'data' => ArrayHelper::map(Category::find()->asArray()->all(), 'id', 'name'),
    'options' => [
        'placeholder' => 'Выбери категорию ...',
        'style' => ['textAlign' => 'center'],
        'id' => 'category-id',
    ],
    'pluginOptions' => [
        'allowClear' => true
    ],
]);?>

<?= $form->field($product, 'id')->widget(DepDrop::classname(), [
    'options' => ['placeholder' => 'Выбери продукт ...',
        'style' => ['textAlign' => 'center'],
        'id' => 'product-id',],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options' => [
        'pluginOptions' => [
            'allowClear' => true
        ]
    ],
    'pluginOptions' => [
        'depends' => ['category-id'],
        'loading' => false,
        'url' => Url::to(['/product/get-product']),
    ]
])->label('Продукт');?>

<?= $form->field($item, 'id')->widget(DepDrop::classname(), [
    'id' => 'item-id',
    'options' => ['placeholder' => 'Выбери товар ...'],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
    'pluginOptions' => [
        'depends' => ['product-id'],
        'loading' => false,
        'url' => Url::to(['/item/get-item']),
    ]
])->label('Товар');?>

<?= $form->field($item, 'sizes')->widget(DepDrop::classname(), [
    'id' => 'item-size-id',
    'options' => ['placeholder' => 'Выбери размер ...'],
    'type' => DepDrop::TYPE_SELECT2,
    'select2Options' => ['pluginOptions' => ['allowClear' => true]],
    'pluginOptions' => [
        'nameParam' => 'value',
        'depends' => ['item-id'],
        'loading' => false,
        'url' => Url::to(['/item/get-size']),
    ]
])->label('Размер');?>

<?= $form->field($item, 'quantity')->input('number')->label('Количество')?>

<div class="form-group">
    <?= Html::submitButton('Добавить товар', ['class' => 'btn btn-primary']) ?>
</div>
<?php $form = ActiveForm::end();?>
</div>
