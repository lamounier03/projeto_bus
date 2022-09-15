<?php


include_once("comum/top.php");
include_once('php/db.php');
?>



            <!-- Sale & Revenue Start -->
            <div class="container-fluid pt-4 px-4">
                <div class="row g-2">
                    <div class="col-2">
<?php
$i=0;
$sql = "SELECT * from onibus ORDER BY numero,nome,qut";

$result = $conn->query($sql);
$html='';
$html2='';
    if ($result->num_rows > 0) {
        ?>
            <script>
                let onibus = [];
            </script>
        <?php

        while($row = $result->fetch_assoc()) {
            $i++;
            ?>
            <script>
                onibus.push({'id': '<?php echo $row["id"]; ?>'});
            </script>
            <?php

            echo "
                    <a href='#void' id='button_".$row["id"]."' onclick='exibir_div(".$row["id"].");'>
                        <div class='bg-secondary rounded d-flex align-items-center justify-content-between p-4'>
                            <i class='fa fa-bus fa-2x text-primary' ></i>
                            <div class='ms-3'>
                                <p class='mb-2'>".$row["numero"]."</p>
                            </div>
                        </div>
                    </a>
                ";

            $html.="
                    <div class='bg-secondary rounded h-100 p-4' style='display: none;' id='div_".$row["id"]."'>
                        
                    <div class='boards'>
                        <div class='board'>
                            <h3>Pontos</h3>
                            <div class='dropzone'>
                            ";

                            $sql_pontos = "SELECT * from pontos ORDER BY rua,numero,nome,bairro";

                            $result_pontos = $conn->query($sql_pontos);
                          
                                if ($result_pontos->num_rows > 0) {
                                    while($row_pontos = $result_pontos->fetch_assoc()) {

                                    $html.=" 
                                            <div class='card' draggable='true'>
                                                <div class=''>".$row_pontos["id"]." - ".$row_pontos["rua"]." - ".$row_pontos["numero"]."</div>
                                            </div>
                                        ";
                                    }
                                }

            $html.="        </div>

                        </div>
                        <div class='board'>
                            <h3>Rota <button onclick='salvar(".$i.",".$row["id"].")'  type='submit' id='btn_enviar' class='btn btn-primary'>Salvar</button></h3>
                            <div class='dropzone'>
                            ";

                            $sql_rota = "SELECT pontos from rotas where id_linha=".$row["id"];
                           
                            $result_rota = $conn->query($sql_rota);
                          
                                if ($result_rota->num_rows > 0) {
                                    
                                    while($row_rota = $result_rota->fetch_assoc()) {
                                        $pontos=$row_rota["pontos"];
                                        $sql_rota_pontos = "SELECT * FROM `pontos` WHERE id in (0 $pontos)";
                                        $result_rota_pontos = $conn->query($sql_rota_pontos);
                                        if ($result_rota_pontos->num_rows > 0) {
                                            while($row_rota_pontos = $result_rota_pontos->fetch_assoc()) {
                                                
                                                $html.=" 
                                                    <div class='card' draggable='true'>
                                                        <div class=''>".$row_rota_pontos["id"]." - ".$row_rota_pontos["rua"]." - ".$row_rota_pontos["numero"]."</div>
                                                    </div>
                                                ";
                                                
                                            }
                                        }
                                    
                                    }
                                }

            $html.="  
                            </div>
                        </div>
                    </div>
                    
                    </div>
                    ";
                    $i++;
        }
    }else{
        echo "
            <a href='#void' >
                <div class='bg-secondary rounded d-flex align-items-center justify-content-between p-4'>
                    <i class='fa fa-bus fa-2x text-primary' ></i>
                    <div class='ms-3'>
                        <p class='mb-2'>Sem ônibus cadastrado</p>
                    </div>
                </div>
            </a>
        ";
        $html.="<div class='bg-secondary rounded h-100 p-4' >
                    <p class='mb-2'>Sem ônibus cadastrado</p>
                </div>
            ";
    }
?>

                    </div>
                    <div class="col-10">
                        <?php echo $html; ?>
                    </div>
                    
                </div>
            </div> 
            <!-- Sale & Revenue End -->




<?php
include_once("comum/footer.php");
?>

<script>

document.getElementById("div_"+onibus[0].id).style.display = "block";
var element = document.getElementById("button_"+onibus[0].id);
element.classList.add("text-white")

function exibir_div(id){
    onibus.forEach(function (arrayItem) {
        if(arrayItem.id ==id){
                document.getElementById("div_"+id).style.display = "block";
                var element = document.getElementById("button_"+id);
                element.classList.add("text-white");
            }else{
                document.getElementById("div_"+arrayItem.id).style.display = "none";
                var element = document.getElementById("button_"+arrayItem.id);
                element.classList.remove("text-white");
            }
    });
}

function salvar(x,id){
    

    if(dropzones[x].innerText!=''){

        var model =  dropzones[x].innerText;
        var linhas = model.split('\n');
    
        id_pontos=''
        linhas.forEach(function (itens) {
            var id_aux = itens.split('-');
            
            id_pontos=id_pontos+','+id_aux[0];
        });

        $.ajax({
            type:"POST",
            url:"php/aux_rota.php",
            data:{
                'array':id_pontos,
                'id':id
            },
            dataType:'json',
            success: function(result){
                if(result.status){
                    alert(result.msg);
                    document.location.reload(true);
                }else{
                    alert(result.msg);
                }
            }
        });
    }
}
</script>