<?php
include_once('db.php');

$id=$_POST['id'];
$evento=$_POST['evento'];
$status='';
$msg='';

if($id!='' && $evento!=''){
    
    if($evento=='buscar'){
    
        $sql = "SELECT * from pontos
                WHERE id=$id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                $nome = $row["nome"];
                $rua = $row["rua"];
                $numero = $row["numero"];
                $bairro = $row["bairro"];

                $status=true;
                echo json_encode(array(
                    "nome" => $nome,
                    "numero" => $numero,
                    "rua" => $rua,
                    "bairro" => $bairro,
                    "status" => $status
                ));
            }
        } else {
            $status=false;
        }
        $conn->close();

    }else if($evento=='confirmar'){
        $nome=$_POST['nome'];
        $numero=$_POST['numero'];
        $rua=$_POST['rua'];
        $bairro=$_POST['bairro'];

        if($nome!='' && $numero!='' && $rua!='' && $bairro!=''){
            $sql = "UPDATE pontos 
                    SET nome='$nome',
                        numero='$numero',
                        rua='$rua',
                        bairro='$bairro'
                    WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                $status=true;
                $msg='Ponto alterado com sucesso!';
                echo json_encode(array(
                    "msg" => $msg,
                    "status" => $status
                ));

            }else{
                $status=false;
            }
            $conn->close();        

        }else{
            $status=false;
        }

    }else if($evento=='deletar'){
                $sql = "DELETE FROM pontos WHERE id=$id";

                if($conn->query($sql) === TRUE){
                    $status=true;
                        $msg='Ponto deletado com sucesso!';
                        echo json_encode(array(
                            "msg" => $msg,
                            "status" => $status
                        ));
                }else{
                    $status=false;
                }
                
            }else{
                $status=false;
            }
}else{
    $status=false;
}

if($status==false){
    $msg='Erro!';
   
    echo json_encode(array(
        "msg" => $msg,
        "status" => $status
    ));
}
?>