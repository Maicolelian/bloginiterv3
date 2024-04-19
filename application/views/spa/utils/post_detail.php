<div class="card">
    <div class="card-header">
        <?php if ($this->session->userdata("auth_level") == 9): ?>
            <a target="_blank" href="<?php echo base_url() ?>admin/post_save/<?php echo $post->post_id ?>" class="btn-success btn btn-sm m-2">
                <i class="fa fa-pencil"></i> Editar
            </a>
            <br>
        <?php endif; ?>

        <img src="<?php echo image_post($post->post_id) ?>">
    </div>
    <div class="card-body">

        <?php $this->load->view("blog/utils/social_links"); ?>

        <h1><?php echo $post->title ?></h1>
        <?php echo $post->content ?>
        <a class="btn btn-danger" href="<?php echo base_url() ?>blog/category/<?php echo $post->c_url_clean ?>"><?php echo $post->category ?></a>

    </div>
</div>