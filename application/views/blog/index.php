<?php foreach ($posts as $key => $p) : ?>
    <div class="card post">
        <a href="<?php echo base_url() . 'blog/' . $p->c_url_clean . '/' . $p->url_clean ?>">
        <div class="card-header bg-danger"></div>
        <div class="card-body">
            <img src="<?php echo image_post($p->post_id) ?>" > 
            <h3><?php echo $p->title ?></h3>
            <p><?php echo $p->description ?></p>
        </div>
        </a>
    </div>
    <br>
<?php endforeach; ?>

<?php
$prev = $current_page - 1;
$next = $current_page + 1;

if ($prev < 1)
    $prev = 1;

if ($next > $last_page)
    $next = $last_page;
?>

<ul class= "pagination">
    <li class="page-item"><a class="page-link" href = "<?php echo base_url() . 'blog/' . $prev ?>">Prev</a></li>

    <?php for ($i = 1; $i <= $last_page; $i++) { ?>
        <li class="page-link"><a href ="<?php echo base_url() . 'blog/' . $i; ?> "> <?php echo $i; ?></a></li>
    <?php } ?>

    <?php if ($current_page != $next) { ?>
        <li class="page-link"><a class="next-link" href = "<?php echo base_url() . 'blog/' . $next; ?> ">Sig</a></li>
        <?php } ?>

</ul>
