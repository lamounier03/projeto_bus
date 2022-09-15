<?php
include_once("comum/top.php");
include_once('php/db.php');
?>
<!-- Sale & Revenue Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-line fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Linhas <br> <br></p>
                    <h6 class="mb-0">
                    <?php
                    $sql = "SELECT COUNT(*) as total from onibus ";

                            $result = $conn->query($sql);
                          
                                if ($result->num_rows > 0) {
                                    while($row = $result->fetch_assoc()) {
                                        echo $row["total"];
                                    }
                                }

                    ?>
                    </h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-pie fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">ônibus em trânsito</p>
                    <h6 class="mb-0">26</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-bar fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Passageiro em ônibus</p>
                    <h6 class="mb-0">1234</h6>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xl-3">
            <div class="bg-secondary rounded d-flex align-items-center justify-content-between p-4">
                <i class="fa fa-chart-area fa-3x text-primary"></i>
                <div class="ms-3">
                    <p class="mb-2">Passageiro nos pontos</p>
                    <h6 class="mb-0">734</h6>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Sale & Revenue End -->


<!-- Sales Chart Start -->
<!-- 
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Passageiros em ônibus</h6>
                </div>
                <canvas id="worldwide-sales"></canvas>
            </div>
        </div>
        <div class="col-sm-12 col-xl-6">
            <div class="bg-secondary text-center rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Passageiros nos pontos</h6>
                </div>
                <canvas id="salse-revenue"></canvas>
            </div>
        </div>
    </div>
</div>
-->
<!-- Sales Chart End -->


<!-- Widgets Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-2">
                    <h6 class="mb-0">Mensagens dos passageiros</h6>
                    <a href="">Ver todos</a>
                </div>
                <div class="d-flex mb-2">
                    <input class="form-control bg-dark border-0" id="msg" type="text" placeholder="Escreva uma mensagem.">
                    <button type="button" onclick="add_msg()" class="btn btn-primary ms-2">Add</button>
                </div>
                <?php
                    $sql_msg = "SELECT usuarios.nome,mensagens.msg,mensagens.data_cria from mensagens 
                                    INNER JOIN usuarios on usuarios.id = mensagens.id_usuario ORDER BY mensagens.id DESC LIMIT 4";
                   
                            $result_msg = $conn->query($sql_msg);
                          
                                if ($result_msg->num_rows > 0) {
                                    while($row_msg = $result_msg->fetch_assoc()) {
                                        ?>
                                        <div class="d-flex align-items-center pt-3">
                                            
                                            <div class="w-100 ms-3">
                                                <div class="d-flex w-100 justify-content-between">
                                                    <h6 class="mb-0"><?php echo substr($row_msg["nome"],0,14).".";?></h6>
                                                    <small>
                                                    <?php 
                                                        $date=date_create($row_msg["data_cria"]);
                                                        echo date_format( $date,"d/m/Y H:i"); 
                                                    ?></small>
                                                </div>
                                                <span><?php echo substr($row_msg["msg"],0,50);?></span>
                                            </div>
                                        </div>

                                        <?php 
                                    }
                                }

                    ?>
                
             
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-secondary rounded p-4">
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Calendario</h6>
                </div>
                <div id="calender"></div>
            </div>
        </div>
        <div class="col-sm-12 col-md-6 col-xl-4">
            <div class="h-100 bg-secondary rounded p-4">
                <!--
                <div class="d-flex align-items-center justify-content-between mb-4">
                    <h6 class="mb-0">Tarefas</h6>
                    <a href="">Ver todos</a>
                </div>
                <div class="d-flex mb-2">
                    <input class="form-control bg-dark border-0" type="text" placeholder="Escreva a tarefa">
                    <button type="button" class="btn btn-primary ms-2">Add</button>
                </div>
                
                <div class="d-flex align-items-center border-bottom py-2">
                    <input class="form-check-input m-0" type="checkbox">
                    <div class="w-100 ms-3">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <span>Short task goes here...</span>
                            <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-center pt-2">
                    <input class="form-check-input m-0" type="checkbox">
                    <div class="w-100 ms-3">
                        <div class="d-flex w-100 align-items-center justify-content-between">
                            <span>Short task goes here...</span>
                            <button class="btn btn-sm"><i class="fa fa-times"></i></button>
                        </div>
                    </div>
                </div>-->
            </div>
        </div>
    </div>
</div>
<!-- Widgets End -->
<?php
include_once("comum/footer.php");
?>

<script>

function add_msg(){
    msg=document.getElementById("msg").value;
    if(msg!=''){
        $.ajax({
            type:"POST",
            url:"php/aux_msg.php",
            data:{
                'msg':msg
            },
            dataType:'json',
            success: function(result){
                if(result.status){
                    document.location.reload(true);
                }else{
                    alert(result.msg);
                }
            }
        });
    }
}


</script>