<?php

if (!function_exists("chatpicExists")) {
    function chatpicExists($chatpic) {
        if (preg_match('/(^[a-zA-z]{2})(.*)$/',$chatpic,$matches)) {
            //d($matches);
        
            switch($matches[1]) {
                case 'pb':
                    return pbSearch($matches[2]);
                    break;
                case 'xx':
                    return xxSearch($matches[2]);
                    break;
                default:
                        return 0;
                    break;
            }

        }

        return 0;
      // d($chatpic);
       
    }
}

if (!function_exists("pbSearch")) {
    function pbSearch($chatpic) {

        $pixabayModel = model('App\Models\ChatpicsPixabayModel');

        if ($img = $pixabayModel->select()->where('sid',$chatpic)->first()) {
            return $img;
        }
       //d($chatpic);

       return 0;
       
    }
}

if (!function_exists("xxSearch")) {
    function xxSearch($chatpic) {

        $tpcModel = model('App\Models\ChatpicsTheparkchatModel');

        if ($img = $tpcModel->select()->where('name',$chatpic)->first()) {
            return $img;
        }

       //d($chatpic);

       return 0;
       
    }
}


if (!function_exists("verifyChatpicPermissions")) {
    function verifyChatpicPermissions($chatpic) {

        $auth = service('authentication');
        $authorize = service('authorization');
        
        if ($img = chatpicExists($chatpic)) {
            //d($img);

            if ($img->private ?? NULL) {
                //d($img);
                if ($auth->user()->id != $img->uid) {
                    return 0;
                }
            }
            if ($img->groups) {
                
                return $authorize->inGroup(json_decode($img->groups), $auth->user()->id);
            } 
           
            
            return 1;
            

        }

       return 0;
       
    }
}

if (!function_exists("chatpicCount")) {
    function chatpicCount() {

        // https://stackoverflow.com/a/41848361/5739340
        $path = realpath(FCPATH.'img/chatpics');
        
        $objects = new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator($path),
            RecursiveIteratorIterator::SELF_FIRST
        );
        $count=iterator_count($objects);
        return number_format($count); 
       
    }
}

if (!function_exists("keywordtags")) {
    function keywordtags($data) {
        $tags = array_filter(explode(',',$data));
        $links = null;
        foreach ($tags as $tag) {
            $tag = trim($tag);
            $links[] = anchor(site_url(['chatpics','search',urlencode($tag),'1']),$tag);
        }
        //d($tags,$links);
        return implode(', ',$links);
    }
}

?>