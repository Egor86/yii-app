<?php
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Html;

BootstrapPluginAsset::register($this);

$labelOptions = ['class' => 'control-label'];
$inputOptions = ['class' => 'form-control'];
?>

<div class="form-group" >
    <div class="form-group">
        <?= Html::activeLabel($model, 'title', $labelOptions) ?>
        <?= Html::activeTextInput($model, 'title', $inputOptions) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'keyword', $labelOptions) ?>
        <?= Html::activeTextInput($model, 'keyword', $inputOptions) ?>
    </div>
    <div class="form-group">
        <?= Html::activeLabel($model, 'description', $labelOptions) ?>
        <?= Html::activeTextarea($model, 'description', $inputOptions) ?>
    </div>
</div>