
<div class="col-4">

    <div class="form-group">
        <label>Comentario:</label>
        <textarea class="form-control" id="requestComment"></textarea>
    </div>

    <div class="form-group">
        <label>Estado actual del pedido:</label>
        <select <?php echo $request->request_state_id >= 3 ? "disabled" : "" ?> class="form-control" id="requestStateId">
            <?php foreach ($states as $key => $s) : ?>
                <option <?php echo $request->request_state_id == $s->request_state_id ? "selected" : "" ?> value="<?php echo $s->request_state_id ?>"><?php echo $s->name ?></option>
            <?php endforeach; ?>
        </select>
    </div>
</div>

<script>
    $("#requestStateId").change(function () {
        $.ajax({
            url: "<?php echo base_url() ?>request_store/change_state_request/<?php echo $request->request_id ?>/" + $(this).val(),
            method: 'POST',
            data: {
                comment: $("#requestComment").val()
            }
        }).done(function(data){
            if($("#requestStateId").val() >= 3)
                $("#requestStateId").attr("disabled","disabled")
            
            $("#traces").append(data)
            
        })
    })
</script>
