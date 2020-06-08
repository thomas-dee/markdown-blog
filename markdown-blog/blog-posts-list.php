<?php
    require_once 'getText.php';
    $title = T("blog:title");
    if (T("blog:subtitle") != "blog:subtitle") {
        $title .= " - ".T("blog:subtitle");
    }
?>
<!DOCTYPE html>
<html lang="de">
<head>
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="blog.css">
    <meta name="viewport" content="width=device-width, initial-scale=1">
</head>
<body>
    <div class="blog">
        <?php include 'header.php'; ?>
        <?php include 'blog-info.php'; ?>
        <?php include 'postListRenderer.php'; ?>
    </div>
</body>
</html>
