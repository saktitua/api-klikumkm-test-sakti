<?php 

header("Content-Type:application/json; charset=utf-8");
include "connect.php";

$token = $_POST['token'];
if(empty($_POST['token'])){
    $responsejson = [
        'status'=>'404',
        'message'=>'required token missing'
    ];
    echo json_encode($responsejson);
}else{
    $checktoken  = "SELECT token from  pengguna WHERE token='$token'";
    $querytoken = mysqli_query($conn, $checktoken);
    $datatoken = mysqli_fetch_assoc($querytoken);
    if(isset($datatoken['token'])){
        $get_token = $datatoken['token'];
    }else{
        $get_token = "";
    }
    // var_dump($get_token== $token,$get_token,$token,$datatoken['token']);
    if($get_token== $token){
        $query   = "SELECT * from  biodata";
        $result = mysqli_query($conn, $query);
        $getarr = array();

        while($data = mysqli_fetch_assoc($result)){
            $getarr [] = $data;
        }
        $responsejson = [
            'code'=>200,
            'status'=>'success',
            'data'=>$getarr,
        ];
        echo json_encode($responsejson);
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