<?php
    include 'texts.php';
    
    function T($text) {
        global $texts;
        if (array_key_exists($text, $texts)) {
            return $texts[$text];
        }
        return $text;
    }
?>