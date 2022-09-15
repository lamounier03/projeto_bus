<?php
include_once('db.php');

$id_pontos=$_POST['array'];
$id=$_POST['id'];
$status='';
$msg='';

if($id_pontos!=''){
   
    if($id!=''){
        $sql = "SELECT * from rotas
                    WHERE id_linha=$id";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $sql_update = "UPDATE rotas 
                        SET pontos='$id_pontos'
                        WHERE id_linha='$id'";

                if ($conn->query($sql_update) === TRUE) {
                    $status=true;
                    $msg='Rota salva com sucesso!';
                    echo json_encode(array(
                        "msg" => $msg,
                        "status" => $status
                    ));

                }else{
                    $status=false;
                    $msg='Erro4!';
                }
                
            }
        }else{
            $sql = "INSERT INTO rotas (id_linha, pontos, data_cria)
            VALUES ('$id', '$id_pontos','".date('Y-m-d H:i:s')."')";
            
            if ($conn->query($sql) === TRUE) {
                $status=true;
                $msg='Rota salva com sucesso!';
                echo json_encode(array(
                    "msg" => $msg,
                    "status" => $status
                ));
            } else {
                $status=false;
                $msg='Erro2!';
            }
        }
    
    }else{
        $sql = "INSERT INTO rotas (id_linha, pontos, data_cria)
        VALUES ('$id', '$id_pontos','".date('Y-m-d H:i:s')."')";
        
        if ($conn->query($sql) === TRUE) {
            $status=true;
            $msg='Rota salva com sucesso!';
            echo json_encode(array(
                "msg" => $msg,
                "status" => $status
            ));
        } else {
            $status=false;
            $msg='Erro2!';
        }

    }



}else{
    $status=false;
    $msg='Erro1!';
}

if($status==false){
   
    echo json_encode(array(
        "msg" => $msg,
        "status" => $status
    ));
}
?>