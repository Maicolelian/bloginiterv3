<script src="<?php echo base_url() ?>assets/js/admin/lib/dropzone.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>assets/css/admin/lib/dropzone.css">

<form action="<?php echo base_url() ?>products/upload_image/<?php echo $product->product_id ?>"
      class="dropzone"
      id="upload-file"></form>

<script>
    Dropzone.options.uploadFile = {
        dictDefaultMessage: "<h3>Arrastre o click para cargar imágenes</h3><i class='text-success fa fa-4x fa-cloud-upload'></i>",
        paramName: "image", // The name that will be used to transfer the file
        maxFilesize: 2, // MB
        addRemoveLinks: true,
        dictRemoveFile: "Eliminar",
        dictRemoveFileConfirmation:"¿Seguro que desea eliminar la imagen seleccionada?",
        removedfile: function (file) {
            $.ajax({
                type: 'POST',
                url: "<?php echo base_url() ?>products/image_delete",
                data: {image: file.name}
            });

            file.previewElement.remove();
        },
        accept: function (file, done) {
            if (file.name == "justinbieber.jpg") {
                done("Naha, you don't.");
            } else {
                done();
            }
        },
        init: function () {

            var existingImages = [
<?php foreach ($images as $key => $image) : ?>
                    {name: "<?php echo $image->image ?>", size:<?php echo $image->size ?>},
<?php endforeach; ?>
            ];

            for (i = 0; i < existingImages.length; i++) {
                this.emit("addedfile", existingImages[i]);
                this.emit("thumbnail", existingImages[i], "<?php echo base_url() ?>uploads/product/" + existingImages[i].name);
                this.emit("complete", existingImages[i]);
            }

        }
    };
</script>