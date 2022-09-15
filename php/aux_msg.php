<?php
include_once('db.php');

$msg=$_POST['msg'];
if($msg!=''){
    session_start();
        if(isset($_SESSION['id'])){
           $sql = "INSERT INTO mensagens (msg,id_usuario, data_cria)
            VALUES ('$msg',".$_SESSION['id'].",'".date('Y-m-d H:i:s')."')";
            
            if ($conn->query($sql) === TRUE) {
                $status=true;
                $msg='Mensagem salva com sucesso!';
                echo json_encode(array(
                    "msg" => $msg,
                    "status" => $status
                ));
            } else {
                $status=false;
                $msg='Erro!';
            }

        }else{
            $status=false;
            $msg='Você precisa está logado para adicionar uma mensagem.'; 
        }
   

}else{
    $status=false;
    $msg='Erro!';
}

if($status==false){
   
    echo json_encode(array(
        "msg" => $msg,
        "status" => $status
    ));
}
?>