<?php
require_once 'postRenderer.php';
require_once 'getText.php';

$path = './posts';
$posts_per_page = 5;
$page = 0;
if (isset($_GET["page"])) {
    $page=intval($_GET["page"]);
}

function not_hidden($name) {
    return substr($name, 0, 1) != "_";
}

$all_files = array_filter(array_slice(scandir($path), 2), "not_hidden");
arsort($all_files);
$files = array_slice($all_files, $page * $posts_per_page, $posts_per_page);

foreach ($files as $file) {
    $md = file_get_contents($path . '/' . $file);
    // Get only summary (first lines of post)
    $md = getFirstLines($md, 3);
    $md = addTitleHref($md, $file);
    ?>
    <div class="blog-post">
        <?php echo renderMarkdown($md, getPostDateTime($file)); ?>
        <a href="<?php echo explode('.', $file)[0] ?>">Read post</a>
    </div>
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
        echo "<span style=\"min-width: 40px;\">&nbsp;&nbsp;|&nbsp;&nbsp;</span>";  // spacer to "Overview" link
    }
    echo "<a href=\"" . $href . "\">" . T("Newer") . "</a>";
}

if (($page+1)*$posts_per_page < count($all_files)) {
    echo "<a style=\"float: right\" href=\"?page=" . strval($page+1) . "\">" . T("Older") . "</a>";
}

?>