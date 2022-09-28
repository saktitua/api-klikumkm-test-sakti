<?php 
header("Content-Type:application/json; charset=utf-8");
include "connect.php";
$token   = $_POST['token'];
$nama    = $_POST['nama'];
$no_telp = $_POST['no_telp'];

if(empty($_POST['token'])){
    $responsejson = [
        'status'=>'404',
        'message'=>'required token missing'
    ];
    echo json_encode($responsejson);
}else{
    $checktoken = "SELECT token from  pengguna WHERE token='$token'";
    $querytoken = mysqli_query($conn, $checktoken);
    $datatoken = mysqli_fetch_assoc($querytoken);
    if(isset($datatoken['token'])){
        $get_token = $datatoken['token'];
    }else{
        $get_token = "";
    }
    if($get_token== $token){
        if(!empty($_POST['nama']) && !empty($_POST['no_telp']) && !empty($_FILES['gambar'])){

            $filename = $_FILES['gambar']['name'];
            $upload   = $_SERVER['DOCUMENT_ROOT']."/REST-API-TEST-KLIKUMKM/foto/".$filename;
            file_put_contents($upload, base64_decode($filename));

            var_dump($filename);
            $query = "INSERT INTO biodata (nama,no_telp,gambar) VALUES ('$nama','$no_telp','$filename')";
            $data = mysqli_query($conn,$query);
            if($data){
                $response =[
                    'code'=>200,
                    'status'=>'success',
                    'message'=>'successfully insert',
                ];
                echo json_encode($response);
            }else{
                $response =[
                    'code'=>400,
                    'status'=>'failed',
                    'message'=>'failed insert',
                ];
                echo json_encode($response);
            }
        }else{
            $response =[
                'code'=>404,
                'status'=>'error',
                'message'=>'failed field required',
            ];
            echo json_encode($response);
        }
    }else{
        $responsejson = [
            'code'=>400,
            'status'=>'error',
            'message'=>'token not match',
        ];
        echo json_encode($responsejson);
    }
}

?>