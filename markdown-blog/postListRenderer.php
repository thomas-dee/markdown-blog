<?php
require_once 'postRenderer.php';
require_once 'getText.php';

$path = './posts/*.md';
$posts_per_page = 5;
$page = 0;
if (isset($_GET["page"])) {
    $page=intval($_GET["page"]);
}

function not_hidden($name) {
    return substr(basename($name), 0, 1) != "_";
}

$all_files = array_filter(glob($path), "not_hidden");
arsort($all_files);
$files = array_slice($all_files, $page * $posts_per_page, $posts_per_page);

foreach ($files as $file) {
    $md = file_get_contents($file);

    $file_name = basename($file);
    $image_path = getPostImagePath($file);

    // Get only summary (first lines of post)
    $md = getFirstLines($md, 3);
    $md = addTitleHref($md, $file_name);
    ?>
    <section class="blog-post">
        <div>
        <?php if ($image_path != NULL) { ?>
            <div class="post-list-image-container">
                <img class="post-list-image" src="<?php echo $image_path; ?>" />
            </div>
        <?php } ?>
        <div class="post-list-entry">
            <?php echo renderMarkdown($md, getPostDateTime($file_name)); ?>
            <a href="<?php echo explode('.', $file_name)[0] ?>"><?php echo T("Read post"); ?></a>
        </div>
        </div>
        </section>
    <hr style="margin-bottom: 20px;"/>
<?php 
} 

if ($page > 1) {
    echo "<a href=\"/\">" . T("First") . "</a>";
}
if ($page > 0) {
    $href = "?page=" . strval($page-1);
    if ($page == 1) {
        $href = "/";
    }
    else {
        echo "<span style=\"min-width: 40px;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span>";  // spacer to footer link bar
    }
    echo "<a href=\"" . $href . "\">" . T("Newer") . "</a>";
}

if (($page+1)*$posts_per_page < count($all_files)) {
    echo "<a style=\"float: right\" href=\"?page=" . strval($page+1) . "\">" . T("Older") . "</a>";
}

?>