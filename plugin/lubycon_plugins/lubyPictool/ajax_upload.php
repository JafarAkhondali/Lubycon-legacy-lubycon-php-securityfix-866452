<?php

    //�ӽ� ajax��. ���� ��ȭ�� ���δ��� �� Ŭ�������� �����ų��

    $base64_string = $_POST['data'];
    $output_file = './temp/userthumb.jpg';

    base64_to_jpeg($base64_string, $output_file);

    function base64_to_jpeg($base64_string, $output_file) 
    {
    $ifp = fopen($output_file, "wb"); 

    $data = explode(',', $base64_string);

    fwrite($ifp, base64_decode($data[1])); 
    fclose($ifp); 

    return $output_file; 
    }



?>