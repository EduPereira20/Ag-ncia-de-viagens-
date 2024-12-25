<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="fonts/icomoon/style.css">
    <link rel="stylesheet" href="css/owl.carousel.min.css">
    <link rel="stylesheet" href="../css/bootstrap.min.css">
    <link rel="stylesheet" href="../css/style.css">
    <title>Cadastro - ViajeFácil</title>
</head>
<body>
  
<div class="d-lg-flex half">
    <div class="bg order-1 order-md-1" style="background-image: url('../images/marten-bjork-wGu1pzDSm3g-unsplash.jpg');"></div>
    <div class="contents order-2 order-md-2">
        <div class="container">
            <div class="row align-items-center justify-content-center">
                <div class="col-md-7">
                    <h3>Cadastro <strong>administrador novo</strong></h3>
                    <p class="mb-4">Preencha os campos abaixo.</p>
                    <form action="adicionar_admin.php" method="post" onsubmit="return verificarSenhas()">
                        <div class="form-group first">
                            <label for="name_admin">Nome Completo</label>
                            <input type="text" class="form-control" placeholder="Nome" id="name_admin" name="name_admin" required>
                        </div>
                        <div class="form-group first">
                            <label for="user_admin">Usuário</label> 
                            <input type="text" class="form-control" placeholder="Usuário" id="user_admin" name="user_admin" required>
                        </div>
                        <div class="form-group">
                            <label for="senha">Senha</label>
                            <input type="password" class="form-control" placeholder="Senha" id="senha" name="password_admin" required>
                        </div>
                        <div class="form-group last mb-3">
                            <label for="confirmar_senha">Confirmar Senha</label>
                            <input type="password" class="form-control" placeholder="Confirmar Senha" id="confirmar_senha" required>
                        </div>
                        
                        <input type="submit" value="Cadastrar" class="btn btn-block btn-primary">
                    </form>
                    <br>
                    <p id="erro-senha" style="color: red; display: none;">As senhas devem ser iguais!</p>
                </div>
            </div>
        </div>
    </div>
</div>
    
<script>
    function verificarSenhas() {
        var senha = document.getElementById("senha").value;
        var confirmarSenha = document.getElementById("confirmar_senha").value;
        var erroSenha = document.getElementById("erro-senha");

        if (senha !== confirmarSenha) {
            erroSenha.style.display = "block";
            return false; 
        }
        
        erroSenha.style.display = "none";
        return true; 
    }
</script>
</body>
</html>
