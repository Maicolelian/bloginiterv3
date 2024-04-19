<?php if ($product_id != null): ?>
    <a href="<?php echo base_url() ?>products/product_save" class="btn-success btn btn-sm m-2">
        <i class="fa fa-plus"></i> Crear
    </a>
<?php endif; ?>

<?php echo form_open('', 'class="my_form" enctype="multipart/form-data"'); ?>
<div class="form-group">
    <?php
    echo form_label('Titulo', 'title');
    ?>
    <?php
    $text_input = array(
        'name' => 'title',
        'minlength' => 10,
        'maxlength' => 130,
        'required' => 'required',
        'id' => 'title',
        'value' => $title,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('title', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Url limpia', 'url_clean');
    ?>
    <?php
    $text_input = array(
        'name' => 'url_clean',
        'id' => 'url_clean',
        'value' => $url_clean,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('url_clean', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Precio', 'price');
    ?>
    <?php
    $text_input = array(
        'name' => 'price',
        'id' => 'price',
        'type' => 'number',
        'value' => $price,
        'class' => 'form-control input-lg',
    );

    echo form_input($text_input);
    ?>
    <?php echo form_error('price', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Contenido', 'content');
    ?>
    <?php
    $text_area = array(
        'name' => 'content',
        'id' => 'content',
        'value' => $content,
        'class' => 'form-control input-lg',
    );

    echo form_textarea($text_area);
    ?>
    <?php echo form_error('content', '<div class="text-danger">', '</div>') ?>
</div>

<div class="form-group">
    <?php
    echo form_label('Descripción', 'description');
    ?>
    <?php
    $text_area = array(
        'name' => 'description',
        'id' => 'description',
        'value' => $description,
        'class' => 'form-control input-lg',
    );

    echo form_textarea($text_area);
    ?>
    <?php echo form_error('description', '<div class="text-danger">', '</div>') ?>
</div>

<!--    <div class="form-group">
<?php
//        echo form_label('Imagen', 'image');
?>
<?php
//        $text_input = array(
//            'name' => 'upload',
//            'id' => 'upload',
//            'value' => '',
//            'type' => 'file',
//            'class' => 'form-control input-lg',
//        );
//        echo form_input($text_input);
?>

<?php // echo $image != "" ? '<img class="img_product img-thumbnail img-presentation-small" src="' . base_url() . 'uploads/product/' . $image . '">' : "";  ?>

    </div>-->

<div class="form-group">
    <?php
    echo form_label('Categorias', 'category_id');
    echo form_dropdown('category_id', $categories, $category_id, 'class="form-control input-lg"')
    ?>
</div>

<?php echo form_submit('mysubmit', 'Guardar', 'class="btn btn-primary"') ?>

<?php echo form_close() ?>

<script>
    $(function () {
        var editor = CKEDITOR.replace('content', {
            height: 400,
            filebrowserUploadUrl: "<?php echo base_url() ?>products/upload",
            filebrowserBrowseUrl: "<?php echo base_url() ?>products/images_server"
        });
    });
</script>

