<?php

echo "<hr/><br/>";
echo "email public option = " . $_POST['email_public'];
echo "<br/>origin password = " . $_POST['now_pass'];
echo "<br/>changed password = " . $_POST['pass'];




echo "<br/><br/>-------------crop thumbnail image--------------<br/>";

$cropurl = $_POST['croppicurl'];

echo "croppic url : " . $cropurl;

echo "<br/><br/>-------------crop thumbnail image--------------<br/>";

echo "<br/><br/>user job = " . $_POST['job'];
echo "<br/>select location = " . $_POST['location'];
echo "<br/>type location = " . $_POST['location_text'];

$history_year = $_POST['history_year'];
$history_month = $_POST['history_month'];
$history_kind = $_POST['history_kind'];
$history_text = $_POST['history_text'];
for($i=0 ; $i< count($history_year); $i++)
{
    echo "<br/><br/>history_year". $i . " = " . $history_year[$i];
    echo "<br/>history_month". $i . " = " . $history_month[$i];
    echo "<br/>history_kind". $i . " = " . $history_kind[$i];
    echo "<br/>history_text". $i . " = " . $history_text[$i];
};

$language = $_POST['language'];
$lang_ability = $_POST['lang_ability'];
//$lang_public = $_POST['lang_public'];
for($i=0 ; $i< count($language); $i++)
{
    echo "<br/><br/>language". $i . " = " . $language[$i];
    echo "<br/>lang ability". $i . " = " . $lang_ability[$i];
    //echo "<br/>lang_public". $i . " = " . $lang_public[$i];
};

echo "<br/><br/>description = " . $_POST['desc'];

echo "<br/><br/>mobile number = " . $_POST['mobile_number'];
echo "<br/>mobile public = " . $_POST['mobile_public'];

echo "<br/><br/>fax number = " . $_POST['fax_number'];
echo "<br/>fax public = " . $_POST['fax_public'];

echo "<br/><br/>website url = " . $_POST['website_url'];
echo "<br/>website public = " . $_POST['website_public'];

echo "<hr/><br/>";
print_r($_POST);
echo "<br/><hr/>";
?>