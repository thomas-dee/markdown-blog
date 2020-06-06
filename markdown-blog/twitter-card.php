<?php
    function createTwitterCardMetaInfo($markdown, $twitter_user, $image_path = NULL, $image_info = NULL) {
        if ($twitter_user == "twitter:account") {
            // no twitter account defined
            return array();
        }

        $lines = explode(PHP_EOL, $markdown);

        $title = NULL;
        $description = NULL;
        
        // first, find title
        foreach ($lines as $line) {
            if (strlen($line) > 0) {
                if ($line[0] == '#') {
                    // its a title
                    while ($line[0] == '#') $line = substr($line, 1);
                    $title = trim($line);
                }
                else if ($description == NULL) {
                    $description = $line;
                }
            }

            if ($title != NULL && $description != NULL) {
                break;
            }
        }

        $tag_info = array (
            "twitter:card" => "summary",
            "twitter:site" => "@".$twitter_user,
            "twitter:creator" => "@".$twitter_user,
            "twitter:title" => $title,
            "twitter:description" => $description
        );

        if ($image_path != NULL) {
            $image_url = "";
            if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') 
                $image_url = "https"; 
            else
                $image_url = "http"; 
            
            // Here append the common URL characters. 
            $image_url .= "://"; 
            
            // Append the host(domain name, ip) to the URL. 
            $image_url .= $_SERVER['HTTP_HOST'];
            $image_url .= $image_path; 

            $tag_info["twitter:image"] = $image_url;
        }
        if ($image_info != NULL) {
            $tag_info["twitter:image:alt"] = $image_info;
        }

        return $tag_info;
    }

    function createTwitterInfo($post, $markdown, $twitter_user) {
        $image_name = 'posts/' . substr($post, 0, strlen($post)-3) . '.jpg';
        if (!file_exists($image_name)) {
            $image_name = NULL;
        }
        else {
            $image_name = "/".$image_name;
        }
        return createTwitterCardMetaInfo($markdown, $twitter_user, $image_name);
    }

    function renderTwitterMetaInfo($post, $markdown, $twitter_user) {
        $meta = createTwitterInfo($post, $markdown, $twitter_user);
        foreach ($meta as $name => $content) {
            print('<meta name="' . $name . '" content="' . $content . '" />');
        }
    }
?>