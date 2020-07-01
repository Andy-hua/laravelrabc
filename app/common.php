<?php
if (!function_exists('st')){
    function st(string $path = ''){
        if ($path == ''){
            return "www.xue.com";
        }else{
            return "www.xue.com/".$path;
        }
    }
}

if (!function_exists('treeLevel')){
    function treeLevel(array $data, string $html = '---', int $pid = 0, int $level = 0) {
        static $arr = [];
        foreach ($data as $val) {
            if ($val['pid'] == $pid) {
                $val['html'] = str_repeat($html, $level);
                $val['level'] = $level + 1;
                $arr[] = $val;
                treeLevel($data,$html,$val['id'],$val['level']);;
            }
        }
        return $arr;
    }
}

if (!function_exists('subTree')){
    function subTree(array $data, int $pid = 0) {
        $arr = [];
        foreach ($data as $val){
            if($val['pid'] == $pid){
                $val['sub'] = subTree($data,$val['id']);
                $arr[] = $val;
            }
        }
        return $arr;
    }
}