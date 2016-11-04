<?php
/* @var $this yii\web\View */
/** @var $model common\models\Item*/
/** @var array $dataProvider ArrayDataProvider*/
/** @var array $same_items common\models\Item*/
use common\models\Category;
use common\models\Item;
use common\models\Size;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

$this->title = $model->name;

//$this->registerJs("
//function getSizes(value) {
//        var data = { product_id: ".$model->id.", color_id: value, _csrf: '".Yii::$app->request->getCsrfToken()."'};
//        $.ajax({
//            type: 'post',
//            url: '/item-size/get-size.html',
//            dataType: 'html',
//            data: data,
//            success: function(data) {
//                $('#product-sizes').html(data);
//            }
//        });
//}
//
//", \yii\web\View::POS_HEAD);

$this->registerJs("
$(document).ready(function () {
        var data = { item_id: ".$model->id.", _csrf: '".Yii::$app->request->getCsrfToken()."'};
    $.ajax({
        type: 'post',
        url: '/item-size/check-amount.html',
        dataType: 'html',
        data: data,
        success: function(data) {
            $('#item-size').html(data);
        }        
    })
});

", \yii\web\View::POS_READY);
?>
<h1><?=$model->name;?></h1>

<div class="row">
    <div class="col-md-12 bottom-rule">
        <h2 class="product-price"><?=$model->price;?></h2>
        <h2 class="product-discount-price"><?=$model->discount_price;?></h2>
    </div>
</div><!-- end row -->

<?php for ($i = 0; $i < count($same_items); $i++) : ?>
<?= Html::a($same_items[$i]->color->name, $same_items[$i]->id == $model->id ? null : '/'.$same_items[$i]->slug.Yii::$app->urlManager->suffix)?>
<?php endfor;?>

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

        <?= $form->field($model, 'sizes',
            [
                'template' => "{label}{input}<div id=\"item-size\"></div><div class=\"help-block\"></div>",
            ]
        )->input('hidden', ['value' => '', 'class' => false, 'id' => false])
//            ->radioList(ArrayHelper::map(
//            Size::find()->where(['size_table_name_id' => Category::findOne(['id' => $model->product->category_id])->size_table_name_id])->asArray()->all(), 'id', 'value'),
//            [
//                'disabled' => [1],
//                'item' => function($index, $label, $name, $checked, $value) {
//
//                    $return = '<label class="modal-radio">';
//                    $return .= '<span>' . ucwords($label) . '</span>';
//                    $return .= '<input type="radio" name="' . $name . '" value="' . $value . '" tabindex="3" disabled>';
//                    $return .= '<i></i>';
//                    $return .= '</label>';
//
//                    return $return;
//                }
//            ])
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
        <?= $this->render('_size-table', [
            'dataProvider' => $dataProvider,
            'model' => $model
        ])?>
    </div>
</div><!-- end row -->
