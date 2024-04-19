<table class="table table-striped table-hover">
    <tbody>
        <tr style="font-family: cursive">
          <th style="background-color:silver; width: 10px">N°</th>
          <th style="background-color:silver">Nombre</th>
          <th style="background-color:silver">Acciones</th>
        </tr>
        <?php foreach ($categories as $key => $c) : ?>
        <tr>
            <td><?php echo $c->category_id ?></td>
            <td><?php echo $c->name ?></td>
            <td>
                <a class="btn btn-sm btn-primary" 
                    href="<?php echo base_url() . 'admin/category_save/' . $c->category_id ?>">
                    <i class="fas fa-edit"></i> Editar
                </a>
                <a class="btn btn-sm btn-danger" 
                    data-toggle="modal" 
                    data-target="#deleteModal"
                    href="#"
                    data-categoryid="<?php echo $c->category_id ?>">
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
        <button type="button" class="btn btn-danger" id="borrar-category" data-dismiss="modal">Eliminar </button>
      </div>
    </div>
  </div>
</div>

<script>
    var category_id = 0;
    var buttondelete;

    $('#deleteModal').on('show.bs.modal', function (event) {
    buttondelete = $(event.relatedTarget) 
    category_id = buttondelete.data('categoryid') 
     var modal = $(this)
    modal.find('.modal-title').text('Seguro que quieres eliminar la categoria seleccionada ' + category_id)
    });

    $("#borrar-category").click(function()
    {
        $.ajax({
            url: "<?php echo base_url() ?>admin/category_delete/" + category_id
        }).done(function(res) {
            if(res == 1) {
                $(buttondelete).parent().parent().remove();
            }
        });
    });
</script>