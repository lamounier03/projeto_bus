<?php
include_once('db.php');

$nome=$_POST['nome'];
$email=$_POST['email'];
$senha=$_POST['senha'];
$tipo=$_POST['tipo'];
$status='';
$msg='';

if($nome!='' && $email!='' && $senha!='' && $tipo!=''){
    $senha=md5($senha);
    $msg="$nome - $email - $senha";

    $sql = "INSERT INTO usuarios (nome, email, senha,nivel_usuario,data_cria)
    VALUES ('$nome', '$email', '$senha',$tipo,'".date('Y-m-d H:i:s')."')";
    
    if ($conn->query($sql) === TRUE) {
        $status=true;
        session_start();
        $_SESSION['nome'] = $nome;


    } else {
        $status=true;
        $msg='Erro, tente novamente mais tarde.';
    }


}else{
    $msg='Preencha todos os campos!';
    $status=false;
}



echo json_encode(array(
    "msg" => $msg,
    "status" => $status
));
?>