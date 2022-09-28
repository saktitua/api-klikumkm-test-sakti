<?php 
header("Content-Type:application/json; charset=utf-8");
include "connect.php";

$email   = $_POST['email'];
$pass    = $_POST['pass'];

if(isset($_POST['email']) && isset($_POST['pass'])){
    $query   = "select email from  pengguna WHERE email='$email'";
    $result = mysqli_query($conn, $query);
    $getemail = mysqli_fetch_assoc($result);
    if(isset($getemail['email'])){
        $getemails = $getemail['email'];
    }else{
        $getemails = "";
    }
    if($email !=  $getemails){
        if(!isset($getemail['email'])){
            $encrypted_password = password_hash($pass,PASSWORD_BCRYPT);                                                                                                                                                                              ;
            $token = md5(rand(10,100)); 
            $query = "INSERT INTO pengguna (email,passwords,token) VALUES ('$email','$encrypted_password','$token')";
            $data = mysqli_query($conn,$query);
            if($data){
            $sql = "SELECT * FROM pengguna";
            $getquery = mysqli_query($conn,$sql);
            $emparray = array();
            while($row =mysqli_fetch_assoc($getquery))
            {
                $emparray[] = $row;
            }
    
            $response =[
                'code'=>200,
                'status'=>'success',
                'message'=>'successfully insert',
                'data'=>$emparray,
            ];
        }
        
        }else{
            $response =[
                'code'=>404,
                'status'=>'error',
                'message'=>'failed insert',
            ];
        }
        echo json_encode($response);
    }else{
        $response =[
            'code'=>404,
            'status'=>'error',
            'message'=>'email has been there at database system',
        ];
        echo json_encode($response);
    }     
   
}else{

    $response =[
        'code'=>404,
        'status'=>'error',
        'message'=>'failed field',
    ];
    echo json_encode($response);


}


?>