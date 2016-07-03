<?php
    require_once $two_depth."/class/json_class.php";
    $json_control = new json_control;
    $json_control->json_decode('job',"$one_depth/data/job.json");
    $job_json_Code = $json_control->json_decode_code;
    $json_control->json_decode('country',"$one_depth/data/country.json");
    $country_json_Code = $json_control->json_decode_code;


    require_once $two_depth.'/session/session_class.php';
    //session_start();
    $session = new Session();

    if(($session->GetSessionId() == null) && $session->GetSessionName() == null){
        $LoginState = false;
    }else{
        if($session->SessionExist()){
            
            if(isset($_SESSION['lubycon_validation']))
            {
                $activity = NULL;
                
                if($_SESSION['lubycon_validation'] === "active")
                    $activity = true;
                else if($_SESSION['lubycon_validation'] === "inactive")
                    $activity = false;
                else
                    $activity = false;

                if($activity === false)
                    echo '<script>document.location.href="./php/account/waiting_for_resisting.php"</script>';

            }else{
                $session->DestroySession();
            } 

            $LoginState = true;
            
            $Loginuser_name = isset($_SESSION['lubycon_nick']) ? $_SESSION['lubycon_nick'] : NULL;
            $Loginuser_id= isset($_SESSION['lubycon_id']) ? $_SESSION['lubycon_id'] : NULL;
            $Loginuser_code= isset($_SESSION['lubycon_userCode']) ? $_SESSION['lubycon_userCode'] : NULL;
            $Loginuser_country = isset( $_SESSION['lubycon_countryCode'] ) ? $country_json_Code[$_SESSION['lubycon_countryCode']]['name'] : NULL;
            $Loginuser_job = isset($_SESSION['lubycon_jobCode']) ? $job_json_Code[$_SESSION['lubycon_jobCode']]['name'] : NULL;
            $Loginuser_city = isset($_SESSION['lubycon_city']) ? $_SESSION['lubycon_city'] : NULL;
            // login menu
        }else{
            $LoginState = false;    
        }
    }
?>

<!DOCTYPE html>

<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta name="subject" content="Lubycon" />
    <meta name="description" content="free sources" />
    <meta name="developed" content="Lubycon" />
    <meta name="designed" content="Lubycon" />
    <meta name="robots" content="index" />
    <meta name="copyright" content="copyrights 2015 LUBYCON" />
    <meta name="keywords" content="design, font ,vector, 3d design, community, designers, engineer, 3d printer, illustration, lubycon" />

    <title>Lubycon</title>

    <link rel="icon" href="<?=$one_depth?>/ch/img/logo/lubycon.ico" /> <!-- favicon -->
    <link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Source Sans Pro:200,400,600" type="text/css" />	<!--google web font-->
    <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css" /> <!--icon font-->

    <link href="<?=$one_depth?>/css/layout/normalize.css" rel="stylesheet" type="text/css" />  <!-- web normalize -->
    <link href="<?=$one_depth?>/css/layout/common.css" rel="stylesheet" type="text/css" />  <!-- common css -->
    <link href="<?=$one_depth?>/css/layout/media.css" rel="stylesheet" type="text/css" /> <!-- media query-->
    <link href="<?=$one_depth?>/css/module/lubySelector.css" rel="stylesheet" type="text/css" />
    <link href="<?=$one_depth?>/css/module/lubyAlert.css" rel="stylesheet" type="text/css" />
    <link href="<?=$one_depth?>/css/module/checkBox.css" rel="stylesheet" type="text/css" />
    <link href="<?=$one_depth?>/css/layout/animate.css" rel="stylesheet" type="text/css" /><!--animation for objects-->

    <script type="text/javascript" src="<?=$one_depth?>/js/core/jquery-1.12.2.min.js"></script> <!-- jquery library -->
    <script type="text/javascript" src="<?=$one_depth?>/js/core/jquery-ui.min.js"></script> <!-- jquery library -->
    <script type="text/javascript" src="<?=$one_depth?>/js/module/jquery.lubySelector.js"></script><!--lubySelector-->
    <script type="text/javascript" src="<?=$one_depth?>/js/module/jquery.lubyAlert.js"></script><!--lubyAlert-->
    <script type="text/javascript" src="<?=$one_depth?>/js/module/resizeObject.js"></script>
    <script type="text/javascript" src="<?=$one_depth?>/js/module/sticky.js"></script>
    <script type="text/javascript" src="<?=$one_depth?>/js/module/checkBox.js"></script>
    <script type="text/javascript" src="<?=$one_depth?>/js/core/core.js"></script> <!-- index file js -->
    <script type="text/javascript" src="<?=$one_depth?>/js/core/ui.js"></script><!-- ui file js -->
    <script type="text/javascript" src="<?=$one_depth?>/js/core/mobile.js"></script><!--mobile file js-->
    
    <meta name="viewport" content="width=device-width, height=device-height, user-scalable=no"><!--responsive design enable-->
    <meta name="theme-color" content="#222222"><!--mobile web browser address window will be changed to #222-->
    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>
<body id="bodyer">
<div id="wrapper"> 
    <div id="loading_icon"><i class="fa fa-spinner fa-spin"></i></div>
    <div class="dark_overlay" data-value="dark_overlay"></div>
    <div id="cancel_layer"></div><!--for mobile, It's transparent-->
    <div class="alertKey hidden"></div>
    <aside id="mb-menu-panel" class="visible-mb"><!--mobile panel menu-->
        <header id="mb-user-section">
            <div id="mb-after-signin">
                <?php
                    $userpic = $two_depth."/../../../Lubycon_Contents/user/$Loginuser_code/profile.jpg";
                ?>
                 <figure id="mb-user-pic">
                    <img src=<?=$userpic?>></img>
                </figure>
                <span id="mb-user-info">
                    <span id="mb-user-name"><?=$Loginuser_name?></span>
                    <span id="mb-user-location"><i class="fa fa-map-marker"></i><?=$Loginuser_city?>, <?=$Loginuser_country?></span>
                </span>
                <span id="mb-user-setting">
                    <a href="<?=$two_depth?>/account/resist_password.php">
                    <!--<?=$two_depth?>/personal_page/personal_page.php?cate=account_setting&usernum=<?=$Loginuser_code?>-->
                        <i class="fa fa-gear fa-1x"></i>
                    </a>
                </span>
            </div> 
        </header>
        <ul class="mb-menu-group">
            <p class="mb-menu-title">CONTENTS</p>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/contents/contents_page.php?cate=artwork&mid_cate=1&page=1">
                    <i class="fa fa-picture-o fa-1x"></i>Artwork
                </a>
            </li>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/contents/contents_page.php?cate=vector&mid_cate=1&page=1">
                    <i class="fa fa-object-group fa-1x"></i>Vector
                </a>
            </li>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/contents/contents_page.php?cate=threed&mid_cate=1&page=1">
                    <i class="fa fa-cube fa-1x"></i>3D Model
                </a>
            </li>
        </ul>
        <ul class="mb-menu-group">
            <p class="mb-menu-title">COMMUNITY</p>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/creators_page/creators.php">
                    <i class="fa fa-pencil fa-1x"></i>Creator
                </a>
            </li>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/community/community_page.php?cate=forum">
            	   <i class="fa fa-comments-o fa-1x"></i>Forum
               </a>
            </li>
        </ul>
        <ul class="mb-menu-group">
            <p class="mb-menu-title">MY PAGE</p>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/personal_page/personal_page.php?cate=dashboard&usernum=<?=$Loginuser_code?>">
                    <i class="fa fa-tachometer fa-1x"></i>Dashboard
                </a>
            </li>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/personal_page/personal_page.php?cate=insight&usernum=<?=$Loginuser_code?>">
                    <i class="fa fa-line-chart fa-1x"></i>Insight
                </a>
            </li>
            <li class="mb-menu-list">
                <a href="<?=$two_depth?>/account/account_setting.php">
                    <i class="fa fa-gear fa-1x"></i>Account Setting
                </a>
            </li>
        </ul>
        <ul class="mb-menu-group signin_class">
            <li class="mb-menu-list">
                <a href="<?=$one_depth?>/login_page.php">
                    <i class="fa fa-power-off fa-1x"></i>Sign in
                </a>
            </li>
        </ul>
        <ul class="mb-menu-group after_signin_class">
            <li class="mb-menu-list">
                <a href="<?=$one_depth?>/login_page.php">
                    <i class="fa fa-power-off fa-1x"></i>Sign out
                </a>
            </li>
        </ul>
    </aside>
    <div class="editor_popup modal fadeInDown animated"> <!-- popup start -->
        <p>Which content will you upload?</p>
        <ul>
            <li>
                <a href="<?=$two_depth?>/editor/core/2d/editor2d.php?cate=artwork">
                <i class="fa fa-picture-o"></i>
                <p>Artwork</p>
                </a>
            </li>
            <li>
                <a href="<?=$two_depth?>/editor/core/2d/editor2d.php?cate=vector">
                <i class="fa fa-object-group"></i>
                <p>Vector</p>
                </a>
            </li>
            <li>
                <a href="<?=$two_depth?>/editor/core/3d/editor3d.php?cate=threed">
                <i class="fa fa-cube"></i>
                <p>3D Model</p>
                </a>
            </li>
        </ul>
        <button class="modal-closebt" data-value="modal-closebt"></button>
    </div><!-- popup end -->
    <header class="main_header">
        <div id="mb-menu" class="visible-mb"><i class="fa fa-bars"></i></div>
        <h1 id="main-logo">
            <a href="<?=$one_depth?>/index.php">
                <img class="hidden-mb-ib" src="<?=$one_depth?>/ch/img/logo/Lubycon_Logo_Title.svg" />
                <img class="visible-mb" src="<?=$one_depth?>/ch/img/logo/Lubycon_Title.svg" />
            </a>
            <span id="beta_version" class="hidden-mb-b">BETA</span><!--beta mark-->
        </h1><!--LUBYCON LOGO-->

        <nav id="main_gnb" class="hidden-mb-b">
            <ul id="gnb">
                <li class="bigsub">
                    <a href="<?=$two_depth?>/contents/contents_page.php?cate=all&mid_cate=1&page=1" class="bigsub_link">
                        Contents
                    </a>
                    <ul class="sub_menu">
                        <li>
                            <a href="<?=$two_depth?>/contents/contents_page.php?cate=artwork&mid_cate=1&page=1"><i class="fa fa-picture-o fa-1x"></i><p>Artwork</p></a>
                        </li>
                        <li>
                            <a href="<?=$two_depth?>/contents/contents_page.php?cate=vector&mid_cate=1&page=1"><i class="fa fa-object-group fa-1x"></i><p>Vector</p></a>
                        </li>
                        <li>
                            <a href="<?=$two_depth?>/contents/contents_page.php?cate=threed&mid_cate=1&page=1"><i class="fa fa-cube fa-1x"></i><p>3D Model</p></a>
                        </li>
                    </ul>	<!--end Contents menu-->
                </li>
                <li class="menu_bar"></li>
                <li class="bigsub">
                    Community
                    <ul class="sub_menu">
                        <li><!--ranking-->
                            <a href="<?=$two_depth?>/creators_page/creators.php"><i class="fa fa-pencil fa-1x"></i><p>Creators</p></a>
                        </li>
                        <li><!--forum-->
                            <a href="<?=$two_depth?>/community/community_page.php?cate=forum"><i class="fa fa-comments-o fa-1x"></i><p>Forum</p></a>
                        </li>
                        <li><!--tutorial-->
                            <a href="<?=$two_depth?>/community/community_page.php?cate=tutorial"><i class="fa fa-book fa-1x"></i><p>Tutorial</p></a>
                        </li>
                        <li><!--Q&A-->
                            <a href="<?=$two_depth?>/community/community_page.php?cate=qna"><i class="fa fa-question fa-1x"></i><p>Q&amp;A</p></a>
                        </li>
                    </ul>	<!--end Community menu-->
                </li>
            </ul> <!-- end gnb ul -->
        </nav>	<!--end main_gnb-->
        <div id="signin_bt" class="hidden-mb-b signin_class"><!-- before sign in -->
            <div id="signin">
                <a href="<?=$one_depth?>/login_page.php">
                    <p class="signicon"><i class="fa fa-unlock-alt fa-lg"></i></p>
                    <p class="signin">SIGN IN</p>
                </a>
            </div>  <!-- end signin -->
        </div><!-- before sign in -->
        <div id="after_signin" class="hidden-mb-b after_signin_class">   <!-- after sign in -->
                <div id="display_user">
                    <figure id="accountImg"><img src="<?=$two_depth?>/../../../Lubycon_Contents/user/<?=$Loginuser_code?>/profile.jpg" alt="profile_img" /></figure>
                    <span id="user_id"><?=$Loginuser_name?></span>
                    <i class="fa fa-angle-down"></i>
                </div>  
            <ul>
                <i class="fa fa-caret-up"></i>
                <div class="userMenuGroup">
                    <li><a href="<?=$two_depth?>/personal_page/personal_page.php?cate=dashboard&usernum=<?=$Loginuser_code?>">
                        <i class="fa fa-tachometer fa-1x"></i>Dashboard
                    </a></li>
                    <li><a href="<?=$two_depth?>/personal_page/personal_page.php?cate=my_contents&usernum=<?=$Loginuser_code?>&page=1">
                        <i class="fa fa-picture-o fa-1x"></i>My Contents
                    </a></li>
                    <li><a href="<?=$two_depth?>/personal_page/personal_page.php?cate=my_forums&usernum=<?=$Loginuser_code?>&page=1">
                        <i class="fa fa-comments-o fa-1x"></i>My Forums
                    </a></li>
                    <li><a href="<?=$two_depth?>/personal_page/personal_page.php?cate=insight&usernum=<?=$Loginuser_code?>">
                        <i class="fa fa-line-chart fa-1x"></i>Insight
                    </a></li>
                    <li><a href="<?=$two_depth?>/personal_page/personal_page.php?cate=bookmark&usernum=<?=$Loginuser_code?>&page=1">
                        <i class="fa fa-star fa-1x"></i>Bookmarks
                    </a></li>
                </div>
                <div class="userMenuGroup">
                    <li><a href="<?=$two_depth?>/account/resist_password.php?usernum=<?=$Loginuser_code?>">
                        <i class="fa fa-gear fa-1x"></i>Account Setting
                    </a></li>
                    <li><a href="<?=$two_depth?>/account/password_setting.php?usernum=<?=$Loginuser_code?>">
                        <i class="fa fa-lock fa-1x"></i>Password Setting
                    </a></li>
                    <li style="display:none;"><a href="<?=$two_depth?>/personal_page/personal_page.php?cate=message">
                        <i class="fa fa-envelope fa-1x"></i>Message
                    </a></li>
                    <li id="sign_out"><a href="<?=$one_depth?>/logout.php">
                        <i class="fa fa-power-off fa-1x"></i>Sign Out
                    </a></li>
                </div>
            </ul>
        </div><!-- end after sign in -->
        <button id="addcontent_bt" class="btn hidden-mb-b" data-tip="add content"><i class="fa fa-plus"></i>Add Contents</button>
        <!-- langage -->
        <div id="lang_select_bt" class="hidden-mb-b" style="display: none;"><!--end content button-->
            <ul>
                <li class="lang_selected">ENG</li>
                <ul class="lang_list">
                    <li>CHI</li>
                    <li class="selected_language">ENG</li>
                    <li>FRA</li>
                    <li>GER</li>
                    <li>JPN</li>
                    <li>KOR</li>
                    <li>RUS</li>
                    <li>SPA</li>
                </ul>	<!-- end lang_list -->
            </ul>	<!-- end lang_all -->
        </div>	<!-- end lang_select_bt -->
        <div id="mb-search" class="visible-mb"><i class="fa fa-search"></i></div>
    </header><!---------------- header end ---------------->
    <div id="main_search_bar" class="search-bar"><!---------------- search bar start ---------------->
        <input type="text" class="search-bar-text" value="Enter the keyword" />
        <button class="out search-btn">
            <i class="fa fa-search"></i>
        </button>
        <div class="select-box">|
            <select class="searchFilter">
                <option data-value="All">All</option>
                <option data-value="Contents">Contents</option>
                <option data-value="Creatorr">Creator</option>
                <option data-value="Community">Community</option>
            </select>
        </div>
        <?php
            if( $LoginState )
            {
                echo ('<script>$(".signin_class").remove();$(".after_signin_class,#addcontent_bt").show();</script>');
            }
        ?>
        <script>
            var searchFilter = $("body").find(".searchFilter");
            searchFilter.lubySelector({
                width: 130,
                theme: "transparent",
                icon: ""
            });
        </script>
        <!-- end select_box -->
    </div><!---------------- search bar end ---------------->
    <!---------------- common parts end ---------------->