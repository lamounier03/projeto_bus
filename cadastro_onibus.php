<?php


include_once("comum/top.php");
?>



<!-- Other Elements Start -->
<div class="container-fluid pt-4 px-4">
    <div class="row g-4">
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Cadastro de ônibus</h6>
                <form>
                    <div class="mb-3">
                        <label for="nome" class="form-label">Linha</label>
                        <input type="text" class="form-control" id="nome">
                    </div>
                    <div class="mb-3">
                        <label for="numero" class="form-label">Número</label>
                        <input type="text" class="form-control" id="numero">
                    </div>
                    <div class="mb-3">
                        <label for="qut" class="form-label">Quantidade de passageiros</label>
                        <input type="number" class="form-control" id="qut">
                    </div>
                    
                    <button type="submit" id="btn_enviar" class="btn btn-primary">Salvar</button>
                </form>
            </div>
        </div>
     
        <div class="col-12">
            <div class="bg-secondary rounded h-100 p-4">
                <h6 class="mb-4">Ônibus cadastrados</h6>
                            
<?php
include_once('php/db.php');
$sql = "SELECT * from onibus ORDER BY numero,nome,qut";

$result = $conn->query($sql);

    if ($result->num_rows > 0) {
        ?>
        <table class="table">
            <thead>
                <tr>
                    <th scope="col">cod</th>
                    <th scope="col">Linha</th>
                    <th scope="col">Lotação</th>
                    <th scope="col">Ações</th>
                </tr>
            </thead>
            <tbody>

        <?php
        while($row = $result->fetch_assoc()) {
           
            echo "<tr>
                    <th scope='row'>".$row["numero"]."</th>
                    <td>".$row["nome"]."</td>
                    <td>".$row["qut"]."</td>
                    <td> 
                        <button onclick='editar(".$row["id"].")' type='button' class='btn btn-square btn-outline-warning m-2'><i class='bi bi-pen'></i></button>
                        <button onclick='deletar(".$row["id"].")'type='button' class='btn btn-square btn-outline-primary m-2'><i class='bi bi-trash'></i></button>
                    </td>
                </tr>
                    ";
        }

        ?>
                </tbody>
            </table>
        <?php
    }
?>
            </div>
        </div>
    </div>
</div>
<!-- Other Elements End -->

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
       <h6 class="mb-4 text-dark" id="exampleModalLabel">Editar Ônibus</h6>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
            <input type="hidden" class="form-control text-white" id="id_editar">
            <div class="mb-3">
                <label for="nome" class="form-label text-dark">Linha</label>
                <input type="text" class="form-control text-white" id="nome_editar">
            </div>
             <div class="mb-3">
                <label for="numero" class="form-label text-dark">Número</label>
                 <input type="text" class="form-control text-white" id="numero_editar">
             </div>
             <div class="mb-3">
                  <label for="qut" class="form-label text-dark">Lotação</label>
                 <input type="number" class="form-control text-white" id="qut_editar">
             </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
        <button type="button" id="confirmar_edicao" class="btn btn-primary">Salvar</button>
      </div>
    </div>
  </div>
</div>
<?php
include_once("comum/footer.php");
?>


<script>
$("#btn_enviar").click(function() {
  
    nome=document.getElementById('nome').value;
    numero=document.getElementById('numero').value;
    qut=document.getElementById('qut').value;

    if(nome!='' && numero!='' && qut!=''){
        $.ajax({
            type:"POST",
            url:"php/aux_onibus.php",
            data:{
                'nome':nome,
                'numero':numero,
                'qut':qut,
                'evento':'novo'
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
    }else{
         alert("Preencha todos os campos!");
    }
   
});

function editar(x){
    if(x!=''){
        $.ajax({
            type:"POST",
            url:"php/aux_onibus.php",
            data:{
                'id':x,
                'evento':'buscar'
            },
            dataType:'json',
            success: function(result){
                if(result.status){
                    document.getElementById('nome_editar').value=result.nome;
                    document.getElementById('numero_editar').value=result.numero;
                    document.getElementById('qut_editar').value=result.qut;
                    document.getElementById('id_editar').value=x;
                    var myModal = new bootstrap.Modal(document.getElementById('exampleModal'));
                    myModal.show();

                }else{
                    alert(result.msg);
                }
            }
        });
        

    }
}

$("#confirmar_edicao").click(function() {
  
  nome=document.getElementById('nome_editar').value;
  numero=document.getElementById('numero_editar').value;
  qut=document.getElementById('qut_editar').value;
  id=document.getElementById('id_editar').value;

  if(nome!='' && numero!='' && qut!=''){
      $.ajax({
          type:"POST",
          url:"php/aux_onibus.php",
          data:{
              'id':id,
              'nome':nome,
              'numero':numero,
              'qut':qut,
              'evento':'confirmar'
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
  }else{
       alert("Preencha todos os campos!");
  }
 
});


function deletar(x){
    if(x!=''){
        if (confirm("Tem certeza de queseja deletar o ônibus id "+x) == true) {
            $.ajax({
          type:"POST",
          url:"php/aux_onibus.php",
          data:{
              'id':x,
              'evento':'deletar'
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
}
</script>