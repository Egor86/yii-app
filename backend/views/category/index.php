<?php

use common\models\Category;
use common\models\SizeTableName;
use kotchuprik\sortable\grid\Column;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Категории';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
$( ".delete" ).click(function() {
    var id = $(this).data("category-id");
    $.ajax({
    url: "category/delete",
    method: "post",
    data: {id: id},
    success: function(data){
    var data = JSON.parse(data);
        if (data["success"]) {
            $("#error-box").addClass("alert alert-success").text("Категория # " + id + " была удалена");
            $("[data-key = " + id +"]").remove();   
        } else {
            $("#error-box").addClass("alert alert-danger").text(data["messages"]["kv-detail-error"]);
        }
    }
    })
});
', \yii\web\View::POS_END)
?>
<div class="category-index">
    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать категорию', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <div id="error-box"></div>
<?php Pjax::begin(); ?>
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'summary' => false,
        'rowOptions' => function ($model, $key, $index, $grid) {
            return ['data-sortable-id' => $model->id];
        },
        'columns' => [
            [
                'class' => Column::className(),
            ],
            [
                'attribute' => 'id',
                'filter' => false,
                'options' => [
                    'style' => 'width: 30px'
                ]
            ],
            'name',
            'description:ntext',
            [
                'attribute' => 'parent',
                'value' => function($data){
                    return $data->parent ? Category::findOne($data->parent)->name : 'Родитель';
                },
                'format' => 'html',
                'filter'=> Category::getParentsList(),
            ],
            'slug',
            [
                'attribute' => 'size_table_name_id',
                'value' => function($data){
                    return $data->sizeTableName->name;
                },
                'format' => 'html',
                'filter'=> ArrayHelper::map(SizeTableName::find()->all(), 'id', 'name'),
            ],
            ['class' => 'yii\grid\ActionColumn',
            'template' => '{view} {update} {delete}',
            'buttons' => [
                'delete' => function($url, $model) {
                    return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                        'title' => Yii::t('backend', 'Удалить'),
                        'class' => 'delete',
                        'data-category-id' => $model->id
                    ]);
                }
            ]],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => \yii\helpers\Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
