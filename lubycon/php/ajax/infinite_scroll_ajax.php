<?php
    $one_depth = '../..'; //css js load
    $two_depth = '..'; // php load

    /* require class set value */
    require_once "$two_depth/database/database_class.php";
    $db = new Database();
    require_once "../class/json_class.php";
    $json_control = new json_control;
    require_once "../class/infinite_scroll_class.php";

    $cate_name = $_POST['cate_param']; //form infinite scroll js post ajax
    $page_param = $_POST['page_param']; //form infinite scroll js post ajax
    $now_page_param = $_POST['now_page_param']; //form infinite scroll js post ajax
    $middle_category = $_POST['mid_cate_param']; //form infinite scroll js post ajax
    $sortlist = []; //form infinite scroll js post ajax and not yet...
    /* require class */
    
    $infinite_scroll = new infinite_scroll('content',$cate_name);
    $infinite_scroll->validate_category();
    $infinite_scroll->set_option($now_page_param,$middle_category,true,$page_param);
    $infinite_scroll->set_query();
    $db->query = $infinite_scroll->query;
    $db->askQuery();
    $contents_result = $db->result; //contents data
    $db->query = $infinite_scroll->query_foundRow;
    $db->askQuery();
    $foundRow_result = $db->result; //row count
    $infinite_scroll->count_page($foundRow_result);

    $infinite_scroll->spread_contents($contents_result,$one_depth);
    $infinite_scroll->check_cookie();
    sleep(0.5);
?>