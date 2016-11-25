<?php

/** @var $this \yii\web\View*/
use common\models\Size;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\ActiveForm;

/** @var $sort \yii\data\Sort*/
/** @var $itemSearch frontend\models\ItemSearch*/

//echo '<pre>';
//@print_r(Yii::$app->request->getQueryParam('sort'));
//echo '</pre>';
//exit(__FILE__ .': '. __LINE__);
echo $dataProvider->sort->link('new') . ' | ' . $dataProvider->sort->link('price_high'). ' | ' . $dataProvider->sort->link('price_low'). ' | ' . $dataProvider->sort->link('discount_price');

echo $this->render('//site/item',['item' => $dataProvider->getModels()]);

echo \yii\widgets\LinkPager::widget([
    'pagination'=>$dataProvider->pagination,
]);

$form = ActiveForm::begin(['method' => 'get', 'action' => Url::to(['category/view', 'slug' => $model->slug])]);

echo Html::hiddenInput('sort', Yii::$app->request->getQueryParam('sort'));

echo $form->field($itemSearch, 'sizes')->checkboxList(ArrayHelper::map(Size::find()->all(), 'id', 'value'),[
    'item' => function($index, $label, $name, $checked, $value){
        $checkbox = Html::checkbox($name, $checked, ['value' => $value]);
        return Html::tag('div', Html::label($checkbox . $label), ['class' => 'checkbox']);
    }]);

echo Html::submitButton('submit');

$form = ActiveForm::end();