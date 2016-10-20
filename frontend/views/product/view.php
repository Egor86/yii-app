<?php
/* @var $this yii\web\View */
/** @var object $model common\model\Product*/
/** @var array $dataProvider ArrayDataProvider*/
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $model->name;

$this->registerJs("
function getSizes(value) {
        var data = { product_id: ".$model->id.", color_id: value, _csrf: '".Yii::$app->request->getCsrfToken()."'};
        $.ajax({
            type: 'post',
            url: '/product-color/get-size.html',
            dataType: 'html',
            data: data,
            success: function(data) {
                $('#product-sizes').html(data);
            }
        });
}

", \yii\web\View::POS_HEAD);

$this->registerJs("
$(document).ready(function () {
 var radio = $(\"input[type='radio']\").first();
 radio.prop('checked', true);
 getSizes(radio.val());
});

", \yii\web\View::POS_READY);
?>
<h1><?=$model->name;?></h1>

<div class="row">
    <div class="col-md-12 bottom-rule">
        <h2 class="product-price"><?=$model->price;?></h2>
    </div>
</div><!-- end row -->

<?php $form = ActiveForm::begin(['action' => '/cart/create.html']); ?>

<?= $form->field($model, 'id')->input('hidden');?>
<div class="row add-to-cart">
    <div class="col-md-5 product-qty">
  <span class="btn btn-default btn-lg btn-qty">
   <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
  </span>
        <?= $form->field($model, 'quantity')->input('number');?>
        <span class="btn btn-default btn-lg btn-qty">
   <span class="glyphicon glyphicon-minus" aria-hidden="true"></span>

  </span>

        <?= $form->field($model, 'colors')->radioList(\yii\helpers\ArrayHelper::map($model->getAllowColors(), 'id', 'name' ),
            [
                'item' => function($index, $label, $name, $checked, $value) {

                    $return = '<label class="modal-radio">';
                    $return .= $label;
                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" onclick="getSizes('.$value.')">';
                    $return .= '</label>';

                    return $return;
                }
            ]) ?>

        <?= $form->field($model, 'sizes',
            [
                'template' => "{label}{input}<div id=\"product-sizes\"></div><div class=\"help-block\"></div>",
            ]
        )->input('hidden', ['value' => '', 'class' => false, 'id' => false])
        ?>
    </div>
    <div class="col-md-4">

        <div class="form-group">
            <?= Html::submitButton('Add to Cart', ['class' => 'btn btn-primary']) ?>
        </div>
    </div>
</div><!-- end row -->
<?php ActiveForm::end(); ?>


<div class="row">
    <div class="col-md-12 bottom-rule top-10"></div>
</div><!-- end row -->

<div class="row">
    <div class="col-md-12 top-10">
        <?php $this->render('_size-table', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ])?>
    </div>
</div><!-- end row -->
