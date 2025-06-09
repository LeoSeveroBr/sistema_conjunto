<?php

include('config/conexao.php');
if (isset($_POST['botao'])) {

  $nome = $_POST['nome'];
  $email = $_POST['email'];
  /* $senha = $_POST['senha']; */
  $senha = base64_encode($_POST['senha']);
  $formatoIMG = array('png', 'jpg', 'jpeg', 'JPG', 'gif');
  $extensao = pathinfo($_FILES['fotocontato']['name'], PATHINFO_EXTENSION);

  if (in_array($extensao, $formatoIMG)) {
    $pasta = "img/";
    $temporario = $_FILES['fotocontato']['tmp_name'];
    $novoNome = uniqid() . ".$extensao";

    if (move_uploaded_file($temporario, $pasta . $novoNome)) {

      $cadastro = "INSERT INTO tb_user (nome_user,email_user,senha_user,foto_user) 
      VALUES (:nome,:email,:senha,:foto)";

      try {
        $result = $conexao->prepare($cadastro);

        $result->bindParam(":nome", $nome, PDO::PARAM_STR);
        $result->bindParam(":email", $email, PDO::PARAM_STR);
        $result->bindParam(":senha", $senha, PDO::PARAM_STR);
        $result->bindParam(":foto", $novoNome, PDO::PARAM_STR);
        $result->execute();
        $contar = $result->rowCount();
        if ($contar > 0) {
          echo "<div class='container'>
                                    <div class='alert alert-success alert-dismissible'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <h5><i class='icon fas fa-check'></i> OK!</h5>
                                    Dados inseridos com sucesso !!!
                                  </div>
                                </div>";
          echo "<script>               
                setTimeout(function() {
                  var alert = document.querySelector('.alert');
                  if (alert) {
                    alert.style.display = 'none';
                  }
                }, 5000);
              </script>";
          header("Refresh: 5, index.php");
        } else {
          echo '<div class="container">
                                <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                Dados não Cadastrado !!!
                              </div>
                            </div>';
          header("Refresh: 5, index.php");
        }

      } catch (Exception $e) {
        $cadastro = "ERRO PDO" . $e->getMessage();
      }
    } else {
      echo "Erro, não foi possível fazer o upload do arquivo!";
    }

  } else {
    echo 'Formato da imagem invalido';
  }
}
?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Agenda</title>

  <!-- Google Font: Source Sans Pro -->
  <link rel="stylesheet"
    href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
  <!-- Font Awesome -->
  <link rel="stylesheet" href="plugins/fontawesome-free/css/all.min.css" />
  <!-- icheck bootstrap -->
  <link rel="stylesheet" href="plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
  <!-- Theme style -->
  <link rel="stylesheet" href="dist/css/adminlte.min.css" />
</head>

<body class="hold-transition login-page">
  <div class="login-box">
    <div class="login-logo">
      <a href="#"><b>Criar conta de usuario</b></a>
    </div>
    <!-- /.login-logo -->
    <div class="card">
      <div class="card-body login-card-body">
        <p class="login-box-msg">Dados necessario</p>

        <form action="cad_usuario.php" method="post" enctype="multipart/form-data">
          <div class="input-group mb-3">
            <label for="exampleInputFile">Foto do contato</label>
            <div class="input-group">
              <div class="custom-file">
                <input type="file" class="custom-file-input" id="fotocontato" name="fotocontato" required />
                <label class="custom-file-label" for="exampleInputFile">Arquivo de imagen</label>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="nome" id="nome" name="nome" class="form-control" placeholder="Nome" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="email" id="email" name="email" class="form-control" placeholder="Email" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <input type="senha" id="senha" name="senha" class="form-control" placeholder="Senha" />
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-lock"></span>
              </div>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="col-12">
              <button type="submit" name="botao" class="btn btn-primary btn-block"> Registrar</button>
            </div>
          </div>
          <div class="input-group mb-3">
            <div class="col-12">
              <a name="voltar" class="btn btn-info btn-block" href="index.php"> Voltar</a>
            </div>
          </div>
        </form>
      </div>
      <!-- /.login-card-body -->
    </div>
  </div>
  <!-- /.login-box -->

  <!-- jQuery -->
  <script src="plugins/jquery/jquery.min.js"></script>
  <!-- Bootstrap 4 -->
  <script src="plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
  <!-- AdminLTE App -->
  <script src="dist/js/adminlte.min.js"></script>
</body>

</html>