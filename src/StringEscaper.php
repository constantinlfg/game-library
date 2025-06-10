<?php

trait StringEscaper{
    public function stringEscaper(?string $string=null):string
    {
        return htmlspecialchars(
            $string,
            $flags = ENT_QUOTES | ENT_SUBSTITUTE | ENT_HTML5
        );
    }

    public function stripTagsAndTrim(?string $string):string{

        if(isset($string)){
            $res=strip_tags($string);
            $res=trim($res);
        }
        else{
            $res = "";
        }
        return $res;
    }
}
