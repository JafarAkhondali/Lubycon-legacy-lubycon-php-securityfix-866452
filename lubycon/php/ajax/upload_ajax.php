<?php
// session
echo '1';
require_once '../session/session_class.php';
$session = new Session();
require_once "../class/json_class.php";
$json_control = new json_control;
$json_control->json_decode('top_category',"../../data/top_category.json");
require_once "../class/upload_class.php";
$uploader = new upload($_FILES,$_POST);
include_once '../class/database_class.php';
$db = new Database();

if(($session->GetSessionId() == null) && $session->GetSessionName() == null){
$LoginState = false;
}else{
if($session->SessionExist()){
$LoginState = true;
$Loginuser_name= $_SESSION['lubycon_nick'];
$Loginuser_id= $_SESSION['lubycon_id'];
$Loginuser_code= $_SESSION['lubycon_code'];
}else{
$LoginState = false;
}
}
// session

// variable
// variable

$uploader->fill_array_data(); // fill array data for validate things // preview image able , thumb image able
$uploader->validate_extension_and_size();
$uploader->file_upload_control();
$uploader->html_image_path(); //only 2d editor . modified html src
if($uploader->downable){$uploader->zip_attach('attach');} // if user didn't upload attach files and zip attach option is saved folder name

$topCate_json_Code = $json_control->json_decode_code;
$json_control->json_search($topCate_json_Code,'topCateCode',$uploader->top_category);
$topCate_code = $json_control->search_key; // search top category name to index form json files


$query = 
"INSERT INTO `lubyconboard`.`artwork` 
(`userCode`, `topCategoryCode`, `contentTitle`, `contentDate`, `contentDescription`, `contents`, `userDirectory`, `ccCode`, `downloadAble`) VALUES 
('$Loginuser_name', '$topCate_code', '$uploader->subject', '$uploader->upload_date', '$uploader->desc', '$uploader->contentHTML', '$uploader->upload_path', 'cc', '$uploader->downable')";


//need category code by json
echo $query;

$db->query = $query;
$db->askQuery();
?>