<?php 
header("Content-Type:application/json; charset=utf-8");
include "connect.php";
$token   = $_POST['token'];
$id      = $_POST['id'];

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
        if(!empty($_POST['id'])){
            $query = "SELECT * FROM biodata WHERE id='$id'";
            $result = mysqli_query($conn, $query);
            $data = mysqli_fetch_assoc($result);

            $get_arr [] =[
                'nama'=>$data['nama'],
                'no_telp'=>$data['no_telp']
            ];
            if($data){
                $response =[
                    'code'=>200,
                    'status'=>'success',
                    'data'=>$get_arr,
                ];
                echo json_encode($response);
            }else{
                $response =[
                    'code'=>200,
                    'status'=>'failed',
                    'message'=>'failed get data',
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