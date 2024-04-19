
<div class="jumbotron pt-2 pb-2 clearfix mb-2">
    <h3><span class="badge badge-danger">CREATED</span></h3>
    <p class="ml-3">...</p>
    <p class="text-muted float-right"><?php echo format_date($request->created_at) ?></p>
</div>
<div id="traces">
    <?php foreach ($traces as $key => $t) : ?>
        <?php $this->load->view('request_store/trace_request', array('t' => $t)) ?>
    <?php endforeach; ?>
</div>