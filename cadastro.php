<?php
if(!isset($_SESSION)){
    session_start();
    if(isset($_SESSION['nome'])){
        header("Location: index.php");
    }
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8">
    <title>Pojeto Bus</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@400;600&family=Roboto:wght@500;700&display=swap" rel="stylesheet"> 
    
    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css" rel="stylesheet">


    <!-- Customized Bootstrap Stylesheet -->
    <link href="css/bootstrap.min.css" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="css/style.css" rel="stylesheet">
</head>

<body>
    <div class="container-fluid position-relative d-flex p-0">
        <!-- Spinner Start -->
        <div id="spinner" class="show bg-dark position-fixed translate-middle w-100 vh-100 top-50 start-50 d-flex align-items-center justify-content-center">
            <div class="spinner-border text-primary" style="width: 3rem; height: 3rem;" role="status">
                <span class="sr-only">Carregando...</span>
            </div>
        </div>
        <!-- Spinner End -->


        <!-- Sign Up Start -->
        <div class="container-fluid">
            <div class="row h-100 align-items-center justify-content-center" style="min-height: 100vh;">
                <div class="col-12 col-sm-8 col-md-6 col-lg-5 col-xl-4">
                    <div class="bg-secondary rounded p-4 p-sm-5 my-4 mx-3">
                        <div class="d-flex align-items-center justify-content-between mb-3">
                            <a href="index.html" class="">
                                <h3 class="text-primary"><i class="fa fa-user-edit me-2"></i>Pojeto Bus</h3>
                            </a>
                            <h3>Cadastro</h3>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="text" class="form-control" id="nome" >
                            <label for="nome">Nome</label>
                        </div>
                        <div class="form-floating mb-3">
                            <input type="email" class="form-control" id="email" placeholder="nome@exemplo.com">
                            <label for="email">Email</label>
                        </div>
                        <div class="form-floating mb-4">
                            <input type="password" class="form-control" id="senha" placeholder="Senha">
                            <label for="senha">Senha</label>
                        </div>
                        <fieldset class="row mb-3">
                                    <legend class="col-form-label col-sm-6 pt-0">Tipo de conta</legend>
                                    <div class="col-sm-6">
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios"
                                                id="gridRadios1" value="1" checked>
                                            <label class="form-check-label" for="gridRadios1">
                                                Usuário
                                            </label>
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="gridRadios"
                                                id="gridRadios2" value="2">
                                            <label class="form-check-label" for="gridRadios2">
                                                Administrador
                                            </label>
                                        </div>
                                    </div>
                                </fieldset>
                        <button type="submit" id="btn_enviar" class="btn btn-primary py-3 w-100 mb-4">Cadastrar</button>
                        <p class="text-center mb-0">Já tem conta? <a href="logar.php">Faça login</a></p>
                    </div>
                </div>
            </div>
        </div>
        <!-- Sign Up End -->
    </div>

    <!-- JavaScript Libraries -->
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="lib/tempusdominus/js/tempusdominus-bootstrap-4.min.js"></script>

    <!-- Template Javascript -->
    <script src="js/main.js"></script>


<script>
$( "#btn_enviar" ).click(function() {
    nome=document.getElementById('nome').value;
    email=document.getElementById('email').value;
    senha=document.getElementById('senha').value;
    tipo=document.querySelector('input[name="gridRadios"]:checked').value;
    
    if(nome!='' && email!='' && senha!='' && tipo!=''){

        $.ajax({
            type:"POST",
            url:"php/novo_usuario.php",
            data:{
                'nome':nome,
                'email':email,
                'senha':senha,
                'tipo':tipo
            },
            dataType:'json',
            success: function(result){
                if(result.status){
                    window.location.href = "index.php";
                }else{
                    alert(result.msg)
                }
            }
        });


    }else{
         alert("Preencha todos os campos!");
    }
   
});

</script>
</body>

</html>