<?php
    require_once 'twitter-card.php';

    function renderOpenGraphMetaInfo($post, $markdown, $twitter_user) {
        $meta = createTwitterInfo($post, $markdown, $twitter_user);
        $tag_mapping = array(
            "twitter:title" => "og:title",
            "twitter:description" => "og:description",
            "twitter:image" => "og:image"
        );
        foreach ($tag_mapping as $key => $property) {
            if (array_key_exists($key, $meta)) {
                print('<meta property="' . $property . '" content="' . $meta[$key] . '" />');
            }
        }

        $site_url = "";
        if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
            $site_url = "https"; 
        else
            $site_url = "http"; 
        
        // Here append the common URL characters. 
        $site_url .= "://"; 
        
        // Append the host(domain name, ip) to the URL. 
        $site_url .= $_SERVER['HTTP_HOST'];
        $site_url .= '/'.getPostSlug($post); 

        print('<meta property="og:url" content="' . $site_url . '" />');
        print('<meta property="og:type" content="article" />');
    }

?>