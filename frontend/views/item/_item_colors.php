<?php

/** @var $model common\models\Item*/
use common\helpers\Image;
use common\models\Color;
use common\models\ImageStorage;
use common\models\Item;
use yii\helpers\Url;


$items = Item::find()
    ->where(['product_id' => $model->product_id, 'isDeleted' => false])
    ->andWhere(['not', ['id' => $model->id]])->all();
?>

<a href="#" class="custom-radio active"><label>
<?php
    if ($model->color->type == Color::COLOR_COVER) :
        $image = ImageStorage::findOne(['class' => Color::className(), 'class_item_id' => $model->color->id]);
        echo $image ? '<img src="' . Image::thumb($image->file_path, Yii::getAlias('@front-web'), 38, 38) . '" alt="">' : '';?>
    <?php else:?>
        <span style="background-color: <?= $model->color->rgb_code?>;"></span>
    <?php endif;?>
</label>
</a>

<?php foreach ($items as $item) :?>
    <a href="<?= Url::to(['item/view', 'slug' => $item->slug])?>" class="custom-radio"><label>
            <?php
            if ($item->color->type == Color::COLOR_COVER) :
                $image = ImageStorage::findOne(['class' => Color::className(), 'class_item_id' => $item->color->id]);
                echo $image ? '<img src="' . Image::thumb($image->file_path, Yii::getAlias('@front-web'), 38, 38) . '" alt="">' : '';?>
            <?php else:?>
                <span style="background-color: <?= $item->color->rgb_code?>;"></span>
            <?php endif;?>
        </label>
    </a>
<?php endforeach;?>



