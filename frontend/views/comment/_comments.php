<?php

?>


<?php  foreach ($comments as $comment) : ?>
    <div class="review-item">
        <strong><?= $comment->user_name ?></strong>
        <span> - <?= date("d.m.Y", $comment->created_at) ?></span>
        <p><?= $comment->text ?></p>
    </div>
<?php endforeach;  ?>
