<?php 
header("Content-Type:application/json; charset=utf-8");
include "connect.php";


$responsejson = "";
if(isset($_POST['email'])){
    $email = $_POST['email'];
}
if(isset($_POST['pass'])){
    $pass = $_POST['pass'];
}
$data =[
    "email"=>$email,
    "pass"=>$pass,
];
if(empty($data['email']) && empty($data['pass'])){
    $responsejson = [
        'status'=>'400',
        'message'=>'required field missing'
    ];
    echo json_encode($responsejson);
}else{
    $check = attemlogin($email, $pass, $conn);
    if($check == true){
        $token = md5(rand(10,100)); 
        $update  = "UPDATE  pengguna SET token='$token' WHERE email='$email'";
        mysqli_query($conn, $update);
        $query   = "select token from  pengguna WHERE email='$email'";
        $result = mysqli_query($conn, $query);
        $data = mysqli_fetch_assoc($result);
         
        $responsejson = [
            'code'=>'200',
            'status'=>'success',
            'message'=>'required field missing',
            'data' => [
                'token'=> $data['token']
            ],
        ];
        echo json_encode($responsejson);
    }else{
        $responsejson = [
            'code'=>'400',
            'status'=>'error',
            'message'=>'password and  email not match'
        ];
        echo json_encode($responsejson);
    }

}

function attemlogin($email, $pass, $conn){
    $query  = "SELECT * FROM pengguna WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $data = mysqli_fetch_assoc($result);
 
    $encrypted_password = $data['passwords'];
    if(password_verify($pass,$encrypted_password)){
        return true;
    }else{
        return false;
    }
}

?>