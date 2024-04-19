<?php

header("Content-Type: application/xml; charset=utf-8");
echo '<?xml version="1.0" encoding="UTF-8"?><urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

function urlElement($url) {
    echo '<url>';
    echo "<loc>$url</loc>";
    echo '<changefreq>monthly</changefreq>';
    echo '</url>';
}
?>
<?php echo urlElement(base_url()) ?>
<?php foreach ($posts as $key => $p) : ?>
    <?php echo urlElement(base_url() . 'blog/' . $p->c_url_clean . '/' . $p->url_clean) ?>
<?php endforeach; ?>

<?php echo '</urlset>' ?>