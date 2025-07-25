<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="google-site-verification" content="IDiRooS27YqsymcxNBE2wDm398kjRwzjIQ1iXvzMOPQ" />
<?php
if (isset($blog)) {
    $blog = $blog[0];
    ?>
    <!-- SEO META TAGS -->
    <meta property="og:image" content="<?php echo SITEURL . '/assets/blogs/' . $blog->thumbnail; ?>">
    <meta name="og:title" content="<?php echo $blog->seo_title; ?>">
    <meta name="og:description" content="<?php echo $blog->seo_description; ?>">
    <meta name="og:url" content="<?php echo SITEURL . 'blog/' . $blog->seo_slug; ?>">
    <meta name="author" content="admin">
    <!-- SEO META TAGS -->
    <?php
}
?>
<!-- Favicon icon -->
<!-- <link rel="shortcut icon" type="image/*" href="<?= LANDINGASSETS ?>images/fav/favicon.ico?v=1.2" />
<link rel="apple-touch-icon" sizes="57x57" href="<?= LANDINGASSETS ?>images/fav/apple-icon-57x57.png?v=1.2">
<link rel="apple-touch-icon" sizes="60x60" href="<?= LANDINGASSETS ?>images/fav/apple-icon-60x60.png?v=1.2">
<link rel="apple-touch-icon" sizes="72x72" href="<?= LANDINGASSETS ?>images/fav/apple-icon-72x72.png?v=1.2">
<link rel="apple-touch-icon" sizes="76x76" href="<?= LANDINGASSETS ?>images/fav/apple-icon-76x76.png?v=1.2">
<link rel="apple-touch-icon" sizes="114x114" href="<?= LANDINGASSETS ?>images/fav/apple-icon-114x114.png?v=1.2">
<link rel="apple-touch-icon" sizes="120x120" href="<?= LANDINGASSETS ?>images/fav/apple-icon-120x120.png?v=1.2">
<link rel="apple-touch-icon" sizes="144x144" href="<?= LANDINGASSETS ?>images/fav/apple-icon-144x144.png?v=1.2">
<link rel="apple-touch-icon" sizes="152x152" href="<?= LANDINGASSETS ?>images/fav/apple-icon-152x152.png?v=1.2">
<link rel="apple-touch-icon" sizes="180x180" href="<?= LANDINGASSETS ?>images/fav/apple-icon-180x180.png?v=1.2">
<link rel="icon" type="image/png" sizes="192x192" href="<?= LANDINGASSETS ?>images/fav/android-icon-192x192.png?v=1.2">
<link rel="icon" type="image/png" sizes="32x32" href="<?= LANDINGASSETS ?>images/fav/favicon-32x32.png?v=1.2">
<link rel="icon" type="image/png" sizes="96x96" href="<?= LANDINGASSETS ?>images/fav/favicon-96x96.png?v=1.2">
<link rel="icon" type="image/png" sizes="16x16" href="<?= LANDINGASSETS ?>images/fav/favicon-16x16.png?v=1.2">
<link rel="manifest" href="<?= LANDINGASSETS ?>images/fav/manifest.json?v=1.2"> -->
<!-- <meta name="msapplication-TileColor" content="#ffffff"> -->
<!-- <meta name="msapplication-TileImage" content="<?= LANDINGASSETS ?>images/fav/ms-icon-144x144.png?v=1.2"> -->
<!-- <meta name="theme-color" content="#ffffff"> -->
<title>Adublisher</title>