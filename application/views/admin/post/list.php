<table class="table table-striped table-hover">
    <tbody>
        <tr style="font-family: cursive">
            <th style="background-color:silver; width: 10px">N°</th>
            <th style="background-color:silver">Titulo</th>
            <th style="background-color:silver">Descripcion</th>
            <th style="background-color:silver">Fecha de creacion</th>
            <th style="background-color:silver">Imagen</th>
            <th style="background-color:silver">Publicado</th>
            <th style="background-color:silver">Categoria</th>
            <th style="background-color:silver">Acciones</th>
        </tr>
        <?php foreach ($posts as $key => $p) : ?>
        <tr>
            <td><?php echo $p->post_id ?></td>
            <td><?php echo word_limiter($p->title,4) ?></td>
            <td><?php echo word_limiter($p->description,4) ?></td>
            <td><?php echo format_date($p->created_at) ?></td>
            <td><?php echo $p->image != "" ? '<img class="img_post img-thumbnail img-presentation-small" src="' . base_url() . 'uploads/post/' . $p->image . '">' : ""; ?></td>
            <td><?php echo $p->posted ?></td>
            <td><?php echo $p->category_id ?></td>
            <td>
                <a class="btn btn-sm btn-primary" 
                    href="<?php echo base_url() . 'admin/post_save/' . $p->post_id ?>">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <br>
                <a class="btn btn-sm btn-danger" 
                    data-toggle="modal" 
                    data-target="#deleteModal"
                    href="#"
                    data-postid="<?php echo $p->post_id ?>">
                    <i class="fas fa-trash-alt"></i> Eliminar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>       

<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">New message</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
        <button type="button" class="btn btn-danger" id="borrar-post" data-dismiss="modal">Eliminar </button>
      </div>
    </div>
  </div>
</div>

<script>
    var postid = 0;
    var buttondelete;

    $('#deleteModal').on('show.bs.modal', function (event) {
    buttondelete = $(event.relatedTarget) 
    postid = buttondelete.data('postid') 
     var modal = $(this)
    modal.find('.modal-title').text('Seguro que quieres eliminar el post seleccionado ' + postid)
    });

    $("#borrar-post").click(function()
    {
        $.ajax({
            url: "<?php echo base_url() ?>admin/post_delete/" + postid
        }).done(function(res) {
            if(res == 1) {
                $(buttondelete).parent().parent().remove();
            }
        });
    });
</script>