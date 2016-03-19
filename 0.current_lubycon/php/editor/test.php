<?php
    echo "<br/>-------------zip file upload--------------<br/><br/>";
    $set_date = date("YmdHis");
    $con_cate = $_POST['contents_cate_name'];
    $user_name = 'daniel_zepp';
    
    $upload_dir= '../../../../Lubycon_Contents/contents/' . $con_cate . '/' . $user_name . $set_date . '/' ;
    $whitelist = array('jpg','jpeg','png','psd','gif','bmp','pdd','tif','raw','ai','esp','svg','svgz','iff','fpx','frm','pcx','pct','pic','pxr','sct','tga','vda','icb','vst','alz','zip','rar','jar','7z','hwp','txt','doc','xls','xlsx','docx','pptx','pdf','ppt','me');  
    $limit_size = 3 * 1024 * 1024; // byte

    /*
        if you want modified limite size, change in this php '$limit_size' in editor.js '$size_setting' and in server side php.ini setting
    */

    if(1) //������ѰŶ��
    {
        for($i=0; $i<count($_FILES['upload_file']['name']); $i++) 
        {
            $filename = $_FILES['upload_file']['name'][$i]; // �������� �����̸�
            $ext = substr(strrchr($filename, '.'), 1); // Ȯ���� ����
            if ( !in_array($ext, $whitelist) )  // Ȯ���� �˻�
            {
                echo $filename.' not allow<br/>';
                return false;
            }
            $filesize_array[$i] = $_FILES['upload_file']['size'][$i]; // �� ���ϻ����� ũ�� �迭�� Ǫ��
        }
        if( !array_sum($filesize_array) >= $limit_size ) // ����ũ�� �˻�
        {
            echo array_sum($filesize_array) . 'beyond limite size';
            return false;
        }
        else
        {
            if( mkdir( $upload_dir , 0777) ) // ���丮 ����
            {
                foreach ($_FILES["upload_file"]["error"] as $key => $error)  // ���� ������ŭ foreach �ϸ� ���� ���¸޼��� 
                {
                    if ($error == UPLOAD_ERR_OK) //�̻���ٸ�
                    {
                        $tmp_name = $_FILES["upload_file"]["tmp_name"][$key];
                        $name = $_FILES["upload_file"]["name"][$key];
                        move_uploaded_file($tmp_name, "temp/$name"); // ���� �̵�
                        $filepath_array[$key] = "temp/$name"; // ���� ���ε�� ���
                    }
                }
            }
        }
    }

    require_once "../class/zipfile.php"; // Ŭ�������� �����̾�
    $zipper = new Zipper; //���ۻ���
    $zipper->add($filepath_array); //�����߰�
    $zipper->store($upload_dir.$user_name.'_luby.zip'); //����� zip���� ���
    echo $upload_dir.$user_name.'_luby.zip';

    foreach ($_FILES["upload_file"]["error"] as $key => $error)  // ���� ������ŭ foreach �ϸ� ���� ���¸޼��� 
    {
        unlink( $filepath_array[$key] ); //�ӽ����� ����
    }

    echo "<br/><br/>-------------zip file upload--------------<br/>";

    echo "<br/><br/>-------------crop thumbnail image--------------<br/>";

    $oldfile = $_POST['croppicurl']; // temp file
    $newfile = $upload_dir.'profile.jpg'; // copyed file

    if(file_exists($oldfile)) {
        if(!copy($oldfile, $newfile)) {
            echo "file";
        } else if(file_exists($newfile)) {
            echo '<br/>' . $newfile . "<br/>"; //uploaded file path
        }
    }


    echo "<br/><br/>-------------crop thumbnail image--------------<br/>";

    
    echo "<br/><br/>-------------contents image--------------<br/>";
    $contens_image = $_POST['contents_image'];
    $contens_image_temp_url = '../../../../Lubycon_Contents/contents/temp/';
    if($contens_image) 
    {
        echo "<br/>user upload image = <br/>";
        for($i=0 ; $i< count($contens_image); $i++)
        {
             $oldfile = $contens_image_temp_url.$contens_image[$i]; // temp file
             $newfile = $upload_dir.$contens_image[$i]; // copyed file

             if(file_exists($oldfile)) {
                  if(!copy($oldfile, $newfile)) {
                        echo "file";
                  } else if(file_exists($newfile)) {
                        echo $upload_dir.$contens_image[$i] . "<br/>"; //uploaded file path
                  }
             } 
        };
    };
    echo "<br/><br/>-------------contents image--------------<br/>";


    
    echo "<br/>-------------contents subject name--------------<br/><br/>";

    echo "contents_subject = " . $_POST['contents_subject'];
    
    echo "<br/><br/>-------------contents subject name--------------<br/>";

    /*if($con_article)
    {
        for($k=0 ; $k< count($con_article); $k++)
        {
            echo "<br/>contents article".$k."=";
            echo $con_article[$k];
        };
    };*/
    
    // it's for multiple select box

    $sel_cate = $_POST['user_selected_category'];
    $sel_tag = $_POST['user_selected_tag'];

    echo "<br/><br/>-------------user seleced categories--------------<br/>";
    if($sel_cate) 
    {
        echo "<br/>user selectd categories = ";
        for($i=0 ; $i< count($sel_cate); $i++)
        {
            echo $sel_cate[$i] . " ";
        };
    };
    echo "<br/><br/>-------------user seleced categories--------------<br/>";

    echo "<br/><br/>-------------user seleced tags--------------<br/>";
    if($sel_tag)
    {
        echo "<br/>user selectd tags = ";
        for($j=0 ; $j< count($sel_tag); $j++)
        {
            echo $sel_tag[$j] . " ";
        };
    };
    
    echo "<br/><br/>-------------user seleced tags--------------<br/>";
    
    echo "<br/><br/>-------------contents description--------------<br/>";

    echo "<br/>setting_desc = " . $_POST['setting_desc'];

    echo "<br/><br/>-------------contents description--------------<br/>";

    echo "<br/>-------------text editor html--------------<br/><br/>";
    
    echo htmlspecialchars($_POST['text_editor']);
    
    echo "<br/><br/>-------------text editor html--------------<br/>";

    print_r($_POST);
?>
