<div class="jumbotron pt-2 pb-2 clearfix mb-2">
        <h3><span class="badge badge-danger"><?php echo $t->request_state ?></span></h3>
        <p class="ml-3"><?php echo $t->comment ?></p>
        <p class="text-muted float-right"><?php echo format_date($t->created_at) ?></p>
</div>