<?php

use common\models\Category;
use common\models\Product;
use kartik\select2\Select2;
use kotchuprik\sortable\grid\Column;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;
use yii\helpers\Url;
use yii\widgets\Pjax;
/* @var $this yii\web\View */
/* @var $searchModel backend\models\search\ProductSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Продукты';
$this->params['breadcrumbs'][] = $this->title;

$this->registerJs('
$( ".delete" ).click(function() {
    var id = $(this).data("product-id");
    $.ajax({
    url: "product/delete",
    method: "post",
    data: {id: id},
    success: function(data){
    var data = JSON.parse(data);
        if (data["success"]) {
            $("#error-box").addClass("alert alert-success").text("Товар # " + id + " был удален");
            $("[data-key = " + id +"]").remove();   
        } else {
            $("#error-box").addClass("alert alert-danger").text(data["messages"]["kv-detail-error"]);
        }
    }
    })
});
', \yii\web\View::POS_END)
?>
<div class="product-index">

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Создать продукт', ['create'], ['class' => 'btn btn-success']) ?>
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
                'filter'=> false,
                'options' => [
                    'width' => '15px'
                ]
            ],
            [
                'attribute' => 'name',
                'format' => 'html',
                'options' => [
                    'width' => '300px'
                ]
            ],
//            'brand.name',
            [
                'attribute' => 'video_id',
                'value' => function($data){
                    return $data->video ? $data->video->file_name : null;
                },
                'filter'=> false,
                'options' => [
                    'width' => '250px'
                ]
            ],
            [
                'attribute' => 'category_id',
                'value' => function($data){
                    return $data->category ? $data->category->name : null;
                },
                'format' => 'html',
                'filter'=> Select2::widget([
                    'model' => $searchModel,
                    'attribute' => 'category_id',
                    'name' => 'category_id',
                    'data' => [
                        Category::findOne(1)->name => ArrayHelper::map(Category::find()->where(['parent' => 1])->asArray()->all(), 'id', 'name'),
                        Category::findOne(2)->name => ArrayHelper::map(Category::find()->where(['parent' => 2])->asArray()->all(), 'id', 'name'),
                    ],
                    'options' => [
                        'placeholder' => 'Выбор категории ...',
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]),
            ],
            // 'created_at',
            // 'updated_at',
//            [
//                'attribute' => 'published',
//                'filter'=> ['Нет', 'да'],
//                'options' => [
//                    'width' => '15px'
//                ],
//                'format' => 'boolean'
//            ],
            ['class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'buttons' => [
                    'delete' => function($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', '#', [
                            'title' => Yii::t('backend', 'Удалить'),
                            'class' => 'delete',
                            'data-product-id' => $model->id
                        ]);
                    }
                ]
            ],
        ],
        'options' => [
            'data' => [
                'sortable-widget' => 1,
                'sortable-url' => Url::toRoute(['sorting']),
            ]
        ],
    ]); ?>
<?php Pjax::end(); ?></div>
