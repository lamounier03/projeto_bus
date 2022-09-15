<?php
include_once('db.php');

$nome=$_POST['nome'];
$numero=$_POST['numero'];
$rua=$_POST['rua'];
$bairro=$_POST['bairro'];
$status='';
$msg='';

if($nome!='' && $numero!='' && $rua!='' && $bairro!=''){

    $sql = "INSERT INTO pontos (nome, rua, bairro,numero,data_cria)
    VALUES ('$nome', '$rua', '$bairro','$numero','".date('Y-m-d H:i:s')."')";
    
    if ($conn->query($sql) === TRUE) {
        $status=true;
        $msg='Ponto cadastrado com sucesso!';
    } else {
        $status=false;
        $msg='Erro, tente novamente mais tarde.';
    }


}else{
    $msg='Preencha todos os campos!';
    $status=false;
}

$conn->close();

echo json_encode(array(
    "msg" => $msg,
    "status" => $status
));
?>