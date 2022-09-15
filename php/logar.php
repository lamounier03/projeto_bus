<?php
include_once('db.php');

$email=$_POST['email'];
$senha=$_POST['senha'];
$status='';
$msg='';

if($email!='' && $senha!=''){
    
    $senha=md5($senha);

    $sql = "SELECT nome,id,nivel_usuario from usuarios
            WHERE email='$email'
            and senha='$senha'";

    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            session_start();
            $_SESSION['nome'] = $row["nome"];
            $_SESSION['id'] = $row["id"];
            $_SESSION['nivel_usuario'] = $row["nivel_usuario"];
            $status=true;
        }
    } else {
        $status=false;
        $msg='Erro, senha ou email errados.';
    }
    $conn->close();


}else{
    $msg='Preencha todos os campos!';
    $status=false;
}



echo json_encode(array(
    "msg" => $msg,
    "status" => $status
));
?>