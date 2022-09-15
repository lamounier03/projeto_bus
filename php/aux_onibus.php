<?php
include_once('db.php');

if(isset($_POST['id'])){
    $id=$_POST['id'];
}
$evento=$_POST['evento'];
$status='';
$msg='';

if($evento!=''){
    if($evento=='novo'){
        $nome=$_POST['nome'];
        $numero=$_POST['numero'];
        $qut=$_POST['qut'];

        if($nome!='' && $numero!='' && $qut!='' ){

            $sql = "INSERT INTO onibus (nome, qut,numero,data_cria)
            VALUES ('$nome', '$qut','$numero','".date('Y-m-d H:i:s')."')";
            
            if ($conn->query($sql) === TRUE) {
                $status=true;
                $msg='Ônibus cadastrado com sucesso!';
                echo json_encode(array(
                    "msg" => $msg,
                    "status" => $status
                ));

            } else {
                $status=false;
                $msg='Erro, tente novamente mais tarde.';
            }
        
        }else{
            $msg='Preencha todos os campos!';
            $status=false;
        }
        
        $conn->close();


    }else if($evento=='buscar'){
    
        $sql = "SELECT * from onibus
                WHERE id=$id";

        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                
                $nome = $row["nome"];
                $qut = $row["qut"];
                $numero = $row["numero"];

                $status=true;
                echo json_encode(array(
                    "nome" => $nome,
                    "numero" => $numero,
                    "qut" => $qut,
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
        $qut=$_POST['qut'];

        if($nome!='' && $numero!='' && $qut!=''){
            $sql = "UPDATE onibus 
                    SET nome='$nome',
                        numero='$numero',
                        qut='$qut'
                    WHERE id=$id";
            if ($conn->query($sql) === TRUE) {
                $status=true;
                $msg='ônibus alterado com sucesso!';
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
                $sql = "DELETE FROM onibus WHERE id=$id";

                if($conn->query($sql) === TRUE){
                    $status=true;
                        $msg='Ônibus deletado com sucesso!';
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