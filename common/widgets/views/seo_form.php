<?php
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\Html;

BootstrapPluginAsset::register($this);

$labelOptions = ['class' => 'control-label'];
$inputOptions = ['class' => 'form-control'];
?>

<div class="panel panel-primary">
    <div class="panel-body">
    <div class="form-group" >
        <div class="form-group">
            <div class="col-sm-6">
                <?= Html::activeLabel($model, 'title', $labelOptions) ?>
                <?= Html::activeTextInput($model, 'title', $inputOptions) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-6">
                <?= Html::activeLabel($model, 'keyword', $labelOptions) ?>
                <?= Html::activeTextInput($model, 'keyword', $inputOptions) ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-12">
                <?= Html::activeLabel($model, 'description', $labelOptions) ?>
                <?= Html::activeTextarea($model, 'description', $inputOptions) ?>
            </div>
        </div>
    </div>
    </div>
</div>