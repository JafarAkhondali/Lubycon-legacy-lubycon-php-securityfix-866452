<?php
    require_once "../class/json_class.php";
    $json_control = new json_control;
    $json_control->json_decode('job',"$one_depth/data/job.json");
    $job_json_Code = $json_control->json_decode_code;
    $json_control->json_decode('country',"$one_depth/data/country.json");
    $country_json_Code = $json_control->json_decode_code;
    
    //target user data
    $userjob = $job_json_Code[$userdata_row["jobCode"]]['name'];
    
    $usercountry = $country_json_Code[$userdata_row["countryCode"]]['name'];
    $utc = $country_json_Code[$userdata_row["countryCode"]]["utc"]; 
    echo "<script>var UTC = $utc</script>"; //for watch

    $user_position = $userdata_row["company"];
    $usercity = $userdata_row["city"];
    $language1 = $lang_name[0]; //not yet
    $language2 = $lang_name[1]; //not yet

    $total_like = 0;
    $total_view = 0;
    $total_up = 0;
    $total_down = 0;   
    
    $username = $userdata_row["nick"];
    $userWebsite = $userdata_row["web"];
    $userEmail = $userdata_row["email"];

    $emailpublic = $userdata_row["emailPublic"];
    $mobilepublic = $userdata_row["mobilePublic"];
    $faxpublic = $userdata_row["faxPublic"];
    $webpublic = $userdata_row["webPublic"];


    //target user data

    //login user data
    $usernumber = $_SESSION['lubycon_code'];
    $db->query = "SELECT `countryCode`,`city` FROM `userinfo` WHERE `userinfo`.`userCode` = $usernumber ";
    $db->askQuery();
    $localuserdata_row = mysqli_fetch_array($db->result);

    $localcountry = $country_json_Code[$localuserdata_row["countryCode"]]['name'];
    $localcity = $localuserdata_row["city"];
    //login user data
?>
<script src="<?=$one_depth?>/js/chart/amcharts.js" type="text/javascript"></script>
<script src="<?=$one_depth?>/js/chart/serial.js" type="text/javascript"></script>
<script src="<?=$one_depth?>/js/chart/lubytheme.js" type="text/javascript"></script>
<script src="<?=$one_depth?>/js/dashboard.js" type="text/javascript" ></script>
<div id="information_inbody">
    <ul id="dashboard_wrap">
    
        <li class="dash_section" id="creator_month">
            <div class="dash_header">
                <h4>CREATOR OF THE MONTH</h4>
                <i class="fa fa-angle-up toggle_info"></i>
            </div>
            <div class="dash_body" id="creator_month_body">
                <div class="dash_body_sector" id="dash_creator_infobox">
                    <div class="dash_body_sector" id="dash_creator_info">
                        <figure id="dash_creator_info_background"></figure>
                        <div id="dash_creator_info_p">
                            <figure id="dash_creator_pic_frame">
                                <img src="<?=$one_depth?>/ch/img/creator_of_the_month/SsaRu.png" id="creator_pic">
                            </figure>
                            <ul>
                                <li id="dash_creator_name">SsaRu</li>
                                <li id="dash_creator_job">Engineer</li>
                                <li id="dash_creator_location"><i class="fa fa-map-marker"></i><p>Seoul, South korea</p></li>
                            </ul>
                        </div>
                    </div>
                    </div>
                    <div class="dash_body_sector" id="dash_creator_placed">
                        <p class="dash_body_title">Placed</p>
                        <p class="dash_body_content">September, 2016</p>
                    </div>
                    <div class="dash_body_sector" id="dash_creator_interview">
                        <p class="dash_body_title">Interview</p>
                        <p class="dash_body_content">Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua.</p>
                        <a href="#">VIEW MORE</a>
                    </div>
        </li>
        <li class="dash_section" id="basic_information">
            <div class="dash_header">
                <h4>BASIC INFORMATION</h4>
                <i class="fa fa-angle-down toggle_info selected"></i>
            </div>
            <div class="dash_body">
                <div class="dash_body_sector" id="userjob">
                    <p class="dash_body_title">Job</p>
                    <div class="dash_body_content">
                        <p class="content_text"><?=$userjob?></p>
                    </div>
                </div>
                <div class="dash_body_sector" id="user_position">
                    <p class="dash_body_title">Position</p>
                    <div class="dash_body_content">
                        <p class="content_text"><?=$user_position?></p> 
                    </div>
                </div>
                <div class="dash_body_sector" id="user_location">
                    <p class="dash_body_title">Location</p>
                    <div class="dash_body_content">
                        <p class="content_text"></p>
                        <p class="content_text"><?=$usercountry?></p>
                    </div>
                </div>
                <div class="dash_body_sector" id="user_language">
                    <p class="dash_body_title">Language</p>
                    <div class="dash_body_content">
                        <p class="content_text"><?=$language1?>,</p>
                        <p class="content_text"><?=$language2?></p>
                    </div>
                </div>
            </div>
        </li>
        <li class="dash_section" id="history">
            <div class="dash_header">
                <h4>HISTORY</h4>
                <i class="fa fa-angle-down toggle_info selected"></i>
            </div>
            <div class="dash_body">
                <ul class="history_wrap">
                    <?php
                        while( $row = mysqli_fetch_array($history_row))
                        {
                            $historyYear = $row['historyDateYear'];
                            $historyMonth = $row['historyDateMonth'];
                            $historyCategory = str_replace ( ' ' , '_' , $row['historyCategory'] );
                            $historyContents = $row['historyContents'];
                            echo "<li class='history_list'>
                            <div class='history_date'>$historyYear $historyMonth</div>
                            <div class='history_kind' id='$historyCategory'>
                            <i class='fa fa-circle'></i><span></span></div>
                            <div class='history_content'>'$historyContents</div>
                            </li>";
                        }
                    ?>

                    <!--
                    <li class="history_list">
                        <div class="history_date">2016 Jan</div>
                        <div class="history_kind" id="work_expierence"><i class="fa fa-circle"></i></div>
                        <div class="history_content">Lorem ipsum dolor sit amet, consec tetur adipisicing elit.</div>
                    </li>
                    <li class="history_list">
                        <div class="history_date">2016 May</div>
                        <div class="history_kind" id="studied"><i class="fa fa-circle"></i><span></span></div>
                        <div class="history_content">Lorem ipsum dolor sit amet, consec tetur adipisicing elit.</div>
                    </li>
                    <li class="history_list">
                        <div class="history_date">2017 Sep</div>
                        <div class="history_kind" id="work_expierence"><i class="fa fa-circle"></i><span></span></div>
                        <div class="history_content">Lorem ipsum dolor sit amet, consec tetur adipisicing elit.</div>
                    </li>
                    <li class="history_list">
                        <div class="history_date">2017 Nov</div>
                        <div class="history_kind" id="contest"><i class="fa fa-circle"></i><span></span></div>
                        <div class="history_content">Lorem ipsum dolor sit amet, consec tetur adipisicing elit.</div>
                    </li>
                    <li class="history_list">
                        <div class="history_date">2018 Jan</div>
                        <div class="history_kind" id="studied"><i class="fa fa-circle"></i><span></span></div>
                        <div class="history_content">Lorem ipsum dolor sit amet, consec tetur adipisicing elit.</div>
                    </li>-->
                </ul>
                <aside id="history_desc" class="hidden-mb-ib">
                    <p class="history_desc_list" id="work_desc">
                        <i class="fa fa-circle"></i>
                        <span>Work Experience</span>
                    </p>
                    <p class="history_desc_list" id="edu_desc">
                        <i class="fa fa-circle"></i>
                        <span>Education</span>
                    </p>
                    <p class="history_desc_list" id="award_desc">
                        <i class="fa fa-circle"></i>
                        <span>Awards</span>
                    </p>
                </aside>
            </div>
        </li>
        <li class="dash_section" id="insight">
            <div class="dash_header">
                <h4>INSIGHT</h4>
                <i class="fa fa-angle-down toggle_info selected"></i>
            </div>
            <div class="dash_body">
                <div id="total_counts">
                    <div class="dash_body_sector insight_total" id="total_like">
                        <p class="dash_body_title">Total Like</p>
                        <p class="dash_body_content"><?=$total_like?></p>
                    </div>
                    <div class="dash_body_sector insight_total" id="total_view">
                        <p class="dash_body_title">Total View</p>
                        <p class="dash_body_content"><?=$total_view?></p>
                    </div>
                    <div class="dash_body_sector insight_total" id="total_upload">
                        <p class="dash_body_title">Total Upload</p>
                        <p class="dash_body_content"><?=$total_up?></p>
                    </div>
                    <div class="dash_body_sector insight_total" id="total_download">
                        <p class="dash_body_title">Total Download</p>
                        <p class="dash_body_content"><?=$total_down?></p>
                    </div>
                </div>
                <div id="dash_chart_wrap">
                    <p class="dash_body_title" id="chart_body_title">Last 7 days data</p>
                    <div class="chart_title">
                        <i id="chart_icon" class="fa fa-heart"></i>
                        <span id="chart_name">Like</span>
                        <i id="toggle_arrow" class="fa fa-caret-down"></i>
                    </div>
                    <div id="chart_selector">
                        <ul>
                            <li class="chart_list" data-target="chartdiv1"><i class="fa fa-heart"></i>Like</li>
                            <li class="chart_list" data-target="chartdiv2"><i class="fa fa-eye"></i>View</li>
                            <li class="chart_list" data-target="chartdiv3"><i class="fa fa-cloud-upload"></i>Uploaded</li>
                            <li class="chart_list" data-target="chartdiv4"><i class="fa fa-cloud-download"></i>Downloaded</li>
                        </ul>
                    </div><!--select chart-->
                    <div class="chartboxes" id="chartdiv1" style="width: 100%; height: 350px;"></div>
                    <div class="chartboxes" id="chartdiv2" style="width: 100%; height: 350px;"></div>
                    <div class="chartboxes" id="chartdiv3" style="width: 100%; height: 350px;"></div>
                    <div class="chartboxes" id="chartdiv4" style="width: 100%; height: 350px;"></div>
                </div>
            </div>
        </li>
        <li class="dash_section" id="contact">
            <div class="dash_header">
                <h4>CONTACT</h4>
                <i class="fa fa-angle-down toggle_info selected"></i>
            </div>
            <div class="dash_body">
                <div class="dash_body_sector x2" id="useremail">
                    <div class="x2_inner">
                        <p class="dash_body_title">E-mail</p>
                        <p class="dash_body_content"><?php if($emailpublic=='Public'){echo $userEmail;}else{echo '<i class="fa fa-lock"></i>Private inforamtion';} ?></p>
                    </div>
                    <div class="x2_inner">
                        <p class="dash_body_title">Website</p>
                        <a href=<?php if($webpublic=='Public'){echo $userWebsite;} ?> class="dash_body_content"><?php if($webpublic=='Public'){echo $userWebsite;}else{echo '<i class="fa fa-lock"></i>Private inforamtion';} ?></a>
                    </div> 
                </div>
                <div class="dash_body_sector" id="usertime">
                    <p class="dash_body_title"><?=$username?>`s&nbsp;Time</p>
                    <div class="clock_wrap" data-value="world">
                        <div class="ampm"></div>
                        <div class="clock"></div>
                    </div>
                    <div class="time_location" id="user_location">
                        <?=$usercity?>, <?=$usercountry?>
                    </div>
                </div>
                <div class="dash_body_sector" id="localtime">
                    <p class="dash_body_title">Your Time</p>
                    <div class="clock_wrap" data-value="local">
                        <div class="ampm"></div>
                        <div class="clock"></div>
                    </div>
                    <div class="time_location" id="local_location">
                        <?=$localcity?>, <?=$localcountry?>
                    </div>
                </div>
            </div>
        </li>              
    </ul>
</div>