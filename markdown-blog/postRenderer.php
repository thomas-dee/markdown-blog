<?php
    require_once 'Parsedown.php';
    $Parsedown = new Parsedown();

    function renderMarkdownFile($post) {
        $postSlug = basename($post);
        $date_time = getPostDateTime($postSlug);
        $markdown = file_get_contents($post);
        return renderMarkdown($markdown, $date_time);
    }

    function renderMarkdown($markdown, $date_time = NULL) {
        global $Parsedown;
        $render = $Parsedown->text($markdown);
        if (is_a($date_time, 'DateTime')) {
            $render = '<small>' . $date_time->format("d.m.Y - G:i") . '</small><br />' . $render;
        }
        return $render;
    }

    function getPostImagePath($fileName) {
        $image_path = getPostSlug($fileName) . ".jpg";
        if (file_exists($image_path)) {
            return $image_path;
        }
        return NULL;
    }

    function getPostSlug($fileName) {
        // Post slug is filename, without .md extension
        return substr($fileName, 0, -3);
    }

    function getPostDateTime($fileName) {
        $parts = explode("_", $fileName, 3);
        if (count($parts) == 3) {
            // try to parse date
            return DateTime::createFromFormat("Y-m-d_G-i", join("_", array_slice($parts, 0, 2)));
        }
        return NULL;
    }

    function getPostTitle($postContent) {
        // Gets first # TITLE markdown and returns only text
        $titlePattern = '/^# (.*)/';
        preg_match($titlePattern, $postContent, $matches);
        return $matches[1];
    }

    function addTitleHref($postContent, $link) {
        // Make post title clickable (links to post slug)
        $firstLinePattern = '/^# (.*)(\r\n|\r|\n)$/m';
        $replacement  = '# [${1}]('. $link . ')${2}'; // # [title](slug)NEW_LINE
        return preg_replace($firstLinePattern, $replacement, $postContent);
    }

    function getFirstLines($string, $count) {
        $lines = array_slice(explode(PHP_EOL, $string), 0, $count);
        return implode(PHP_EOL, $lines);
    }
?>