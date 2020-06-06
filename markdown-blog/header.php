<?php 
    require_once 'getText.php';
    function page_not_hidden($name) {
        return substr(basename($name), 0, 1) != "_";
    }
        
    $pages = array_filter(glob('./pages/*.md'), "page_not_hidden");

    global $page_title;
    global $page_subtitle;
    global $overview_title;

    if ($page_title == "") {
        $page_title = "Blog";
    }

    if ($page_subtitle == "") {
        $page_subtitle = "Thomas Döring";
    }

    if ($overview_title == "") {
        $overview_title = "Overview";
    }
?>
    <header>
        <h1><?php echo $page_title; ?></h1>
        <h4><?php echo $page_subtitle; ?></h4>
        <nav>
            <ul>
                <?php if (isset($_GET['post'])) { ?>
                    <li><a href="/"><?php echo T($overview_title); ?></a></li>
                <?php } ?>
                <?php
                    foreach ($pages as $page) {
                        $page_base = substr(basename($page), 0, -3);
                        // Note: title should be set in texts.php!
                        $title = T('page:'.$page_base);
                        print('<li><a href="/'.$page_base.'">'.$title.'</a></li>');
                    }
                ?>
                <li><a title="Link zu meinem Twitterprofil" href="https://twitter.com/thethomasdee"><img style="margin-top: -7px;" width="32" src="resources/Twitter_Logo_Blue.svg" /></a></li>
            </ul>
        </nav>
        <hr style="margin-top: 0px;"/>
    </header>
 <?php ?>