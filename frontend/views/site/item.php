<?php

?>
<?php use yii\helpers\Url;

for ($i =0; $i < count($item); $i++) :?>
    <div class="col-lg-4">

        <h2><?=$item[$i]->name;?></h2>

        <p><?=$item[$i]->price;?></p>

        <p><a class="btn btn-default" href="<?= Url::to(['/cart/create', 'item_id' =>$item[$i]->id]);?>"><?=$item[$i]->id;?></a></p>
        <p><a class="btn btn-default" href="<?= Url::to(['item/view', 'slug' => $item[$i]->slug]);?>">View</a></p>

    </div>
<?php endfor;?>
