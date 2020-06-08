<?php
/**
 * Loads the markdown file given in the ?post query param into $markdown.
 */
require_once 'postRenderer.php';
require_once 'getText.php';
require_once 'twitter-card.php';
require_once 'open-graph-tags.php';

$post = $_GET['post'];

$possible_files = glob('./posts/*'.$post);
$is_page = false;

if (count($possible_files) == 0) {
    // its probably a "page" file
    $possible_files = glob('./pages/'.$post);
    $is_page = true;
    $overview_title = "Blog";
}

if (count($possible_files) > 0) {
    $post = $possible_files[0];
    $postSlug = basename($post);
    $date_time = getPostDateTime($postSlug);
    $image_path = getPostImagePath($post);
    $markdown = file_get_contents($post);
    $postTitle = getPostTitle($markdown);

    if ($is_page) {
        $page_base = substr($postSlug, 0, -3);
        // Note: title should be set in texts.php!
        $page_title = T('page:'.$page_base);
        if ($page_title == 'page:'.$page_base) {
            $page_title = $page_base;
        }
        $postTitle = $page_title;
        if (T("blog:subtitle") != "blog:subtitle") {
            $postTitle .= " - ".T("blog:subtitle");
        }
    }

} else {
    $markdown = "# 404 <br/> Post '" . substr($post, 0, -3) . "' not found &#128533;";
    $postTitle = 'Blog post not found!';
    $date_time = NULL;
    $image_path = NULL;
}
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <link rel="stylesheet" href="blog.css">
    <title><?php echo $postTitle ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php
        require_once 'getText.php';
        if (T("blog:author") != "blog:author") {
            print('<meta name="author" content="' . T("blog:author"). '" />');
        }
    ?>
    <?php 
        renderTwitterMetaInfo($postSlug, $markdown, T("twitter:account")); 
        renderOpenGraphMetaInfo($postSlug, $markdown, T("twitter:account")); 
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
        <article class='markdown'>
            <?php echo renderMarkdown($markdown, $date_time); ?>
        </article>
        <hr style="margin-bottom: 20px;"/>
    </div>
</body>
</html>
