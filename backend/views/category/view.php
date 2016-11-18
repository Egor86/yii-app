<?php
use common\models\Category;
use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\models\Category */

$this->registerJs('
$( ".delete" ).click(function() {
    var id = $(this).data("category-id");
    $.ajax({
    url: "delete",
    method: "post",
    data: {id: id},
    success: function(data){
    var data = JSON.parse(data);
        if (data["success"]) {
            $("#error-box").addClass("alert alert-success").text("Категория # " + id + " была удалена");
            $("#category-view").remove();   
        } else {
            $("#error-box").addClass("alert alert-danger").text(data["messages"]["kv-detail-error"]);
        }
    }
    })
});
', \yii\web\View::POS_END);

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Категории', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
    <div class="category-view">

    <p>
        <?= Html::a('Обновить', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::button('Удалить', [
            'class' => 'btn btn-danger delete',
            'data-category-id' => $model->id
        ]) ?>
    </p>
    <div id="error-box"></div>

<?= DetailView::widget([
    'model' => $model,
    'id' => 'category-view',
    'attributes' => [
//            'id',
        'name',
        'description:ntext',
        [
            'attribute' => 'parent',
            'value' => $model->parent ? Category::findOne($model->parent)->name : 'родитель',
        ],
        'slug',
        [
            'attribute' => 'size_table_name_id',
            'value' => \common\models\SizeTableName::findOne($model->size_table_name_id)->name,
        ],
        'created_at:datetime',
        'updated_at:datetime','seo.title',
        'seo.keyword',
        'seo.description'
    ],
]) ?>