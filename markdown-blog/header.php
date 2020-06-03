<?php 
    require_once 'getText.php';
?>
    <header>
        <h1>Blog</h2>
        <h4>Thomas Döring</h3>
    </header>
    <nav>
        <ul>
            <li><a href="https://twitter.com/thethomasdee"><img style="margin-top: -7px;" width="32" src="resources/Twitter_Logo_Blue.svg" /></a></li>
            <li><a href="/_disclaimer"><?php echo T("Disclaimer"); ?></a></li>
            <?php if (isset($_GET['post'])) { ?>
                <li><a href="/"><?php echo T("Overview"); ?></a></li>
            <?php } ?>
        </ul>
    </nav>
    <hr />
<?php ?>