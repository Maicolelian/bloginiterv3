<div class="card">
    <div class="card-header">
        <img src="<?php echo image_post($post->post_id) ?>">
    </div>
    <div class="card-body">
        <h1><?php echo $post->title ?></h1>
        <?php echo $post->content ?>
    </div>
</div>