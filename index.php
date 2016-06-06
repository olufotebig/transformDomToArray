<?php
function transformDomToArray($dom,$ret_arr){
    // if( $dom->nodeName == '#text'){
    //     return false;
    // }
    $node_name = $dom->nodeName;
    
    $attributes = $dom->attributes;
    if ($attributes != null && $dom->nodeName != '#text'){
        foreach ($attributes as $attribute) {
            $ret_arr[$node_name]['@attrs'][$attribute->name] = $attribute->value;
        }
    }
    $childNodes = $dom->childNodes;
    if(count($childNodes) > 0){
        $do_skip = false;
        if (count($childNodes) == 1){
            if($childNodes[0]->nodeName == '#text'){
                $ret_arr[$node_name]['node_value']= $dom->nodeValue;
                $do_skip = true;
            }
        }
        if (! $do_skip && $dom->nodeName != '#text'){
          foreach ($childNodes as $child) {
              $child_ret_arr = transformDomToArray($child,array());
              $ret_arr[$node_name]['children'][] = $child_ret_arr;
          }  
        }
        
    }

    return $ret_arr;
}
