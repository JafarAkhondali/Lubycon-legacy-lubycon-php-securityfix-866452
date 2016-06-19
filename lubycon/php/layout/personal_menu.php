<aside id="personal_aside" class="con_aside">
    <?php
        require_once '../database/database_class.php';
	    $db = new Database();
        
        $usernumber = $_GET['usernum'];
        $db->query = "SELECT * FROM `userbasic` INNER JOIN `userinfo` ON `userbasic`.`userCode` = `userinfo`.`userCode` WHERE `userbasic`.`userCode` = $usernumber ";
        $db->askQuery();
        $userdata_row = mysqli_fetch_array($db->result);
        $db->query = "SELECT `languageLevel`,`languageName` FROM `userlanguage` WHERE `userCode` = $usernumber";
        $db->askQuery();
        while( $row = mysqli_fetch_array($db->result) )
        {
            $lang_level[] = $row['languageLevel'];
            $lang_name[] = $row['languageName'];
        }
        $db->query = "SELECT `historyContents`,`historyDateYear`,`historyDateMonth`,`historyCategory` FROM `userhistory` WHERE `userCode` = $usernumber";
        $db->askQuery();
        $history_row = $db->result;

        $username = $userdata_row['nick'];
        $user_pic = "$one_depth/../../Lubycon_Contents/user/$usernumber/profile.jpg";
        $user_intro = $userdata_row['userDescription'];
    ?>
    <div id="user_information">
        <div id="userinfo_main">
            <figure id="user_pic">
                <img src="<?=$user_pic?>">
            </figure>
            <h4><?=$username?></h4>
            <h5><?=$user_intro?></h5>
        </div>
    </div>
    <div id="subnav" class="hidden-mb-b">
        <ul>
            <li id="dashboard" class="subnav_li"><a href="../personal_page/personal_page.php?cate=dashboard&usernum=<?=$usernumber?>">Dashboard</a></li>
            <li id="my_contents" class="subnav_li"><a href="../personal_page/personal_page.php?cate=my_contents&usernum=<?=$usernumber?>">Contents</a></li>
            <li id="my_forums" class="subnav_li"><a href="../personal_page/personal_page.php?cate=my_forums&usernum=<?=$usernumber?>">Forums</a></li>
            <li id="insight" class="subnav_li"><a href="../personal_page/personal_page.php?cate=insight&usernum=<?=$usernumber?>">Insight</a></li>
            <li id="bookmark" class="subnav_li"><a href="../personal_page/personal_page.php?cate=bookmark&usernum=<?=$usernumber?>">Bookmark</a></li>
            <?php
            if( $usernumber == $usercode ) //need more security
            {
                echo "<li id='account_setting' class='subnav_li'><a href='../personal_page/personal_page.php?cate=account_setting&usernum=$usercode'>Account Setting</a></li>";
            }
            ?>
            
        </ul>
    </div>
</aside>