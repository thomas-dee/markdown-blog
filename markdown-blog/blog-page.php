<?php
/**
 * Loads the markdown file given in the ?post query param into $markdown.
 */
require_once 'postRenderer.php';
require_once 'getText.php';
require_once 'twitter-card.php';
require_once 'open-graph-tags.php';

$postSlug = $_GET['post'];
$post = 'posts/' . $postSlug;

if (file_exists($post)) {
    $date_time = getPostDateTime($postSlug);
    $image_path = getPostImagePath($post);
    $markdown = file_get_contents($post);
    $postTitle = getPostTitle($markdown);
} else {
    $markdown = "# 404 <br/> Post '$postSlug' not found ðŸ˜¢ ";
    $postTitle = 'Blog post not found!';
    $date_time = NULL;
    $image_path = NULL;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="stylesheet" href="blog.css">
    <title><?php echo $postTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php 
        renderTwitterMetaInfo($postSlug, $markdown, "TheThomasDee"); 
        renderOpenGraphMetaInfo($postSlug, $markdown, "TheThomasDee"); 
        ?>
</head>
<body>
    <div class="blog">
        <?php include 'header.php'; ?>
        <?php 
            if ($image_path != NULL) {
                ?><div class="post-image-container">
                <img class="post-image" src="<?php echo $image_path; ?>" />
                </div><?php
            }
        ?>
        <div class='markdown'>
            <?php echo renderMarkdown($markdown, $date_time); ?>
        </div>
        <hr style="margin-bottom: 20px;"/>
    </div>
</body>
</html>
