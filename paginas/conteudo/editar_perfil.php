<?php
include('../config/conexao.php');
if (isset($_POST['atualizarDados'])) {

  $nome = $_POST['nome'];
  $email = $_POST['email'];
  $id = $_POST['id'];
  $senha = base64_encode($_POST['senha']);

  // Verifica se o campo de upload de arquivo foi preenchido
  if (!empty($_FILES['fotocontato']['name'])) {
    $formatoIMG = array('png', 'jpg', 'jpeg', 'JPG', 'gif');
    $extensao = pathinfo($_FILES['fotocontato']['name'], PATHINFO_EXTENSION);

    if (in_array($extensao, $formatoIMG)) {
      $pasta = "../img/";
      $temporario = $_FILES['fotocontato']['tmp_name'];
      $novoNome = uniqid() . ".$extensao";

      if (move_uploaded_file($temporario, $pasta . $novoNome)) {
        // Query para atualizar a foto
        $cadastro = "UPDATE `tb_user` SET  
                        `foto_user` = :foto,                         
                        `nome_user` = :nome,                        
                        `email_user` = :email,                        
                        `senha_user` = :senha
                        WHERE `id_user` = :id ";
      } else {
        echo "Erro, não foi possível fazer o upload do arquivo!";
        exit;
      }
    } else {
      echo 'Formato da imagem inválido';
      exit;
    }
  } else {
    // Query para atualizar sem alterar a foto
    $cadastro = "UPDATE `tb_user` SET                         
                        `nome_user` = :nome,                        
                        `email_user` = :email,                        
                        `senha_user` = :senha
                        WHERE `id_user` = :id ";
  }

  try {
    $result = $conexao->prepare($cadastro);

    $result->bindParam(":id", $id, PDO::PARAM_INT);
    $result->bindParam(":nome", $nome, PDO::PARAM_STR);
    $result->bindParam(":senha", $senha, PDO::PARAM_STR);
    $result->bindParam(":email", $email, PDO::PARAM_STR);

    // Se o arquivo foi enviado, adicione o parâmetro da foto
    if (!empty($_FILES['fotocontato']['name'])) {
      $result->bindParam(":foto", $novoNome, PDO::PARAM_STR);
    }

    $result->execute();
    $contar = $result->rowCount();
    if ($contar > 0) {
      echo "<div class='container'>
                                    <div class='alert alert-success alert-dismissible'>
                                    <button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;</button>
                                    <h5><i class='icon fas fa-check'></i> OK!</h5>
                                    Dados Atualizado com sucesso !!!
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
      /* header("Refresh: 5, home.php?acao=perfil"); */
    } else {
      echo '<div class="container">
                                <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                ERRO -> Dados não Atualizado !!!
                              </div>
                            </div>';
    }

  } catch (Exception $e) {
    echo "ERRO PDO" . $e->getMessage();
  }
}

?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-8">
          <h1>Editar Perfil</h1>
        </div>
      </div>
    </div>
    <!-- /.container-fluid -->
  </section>

  <!-- Main content -->
  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <!-- left column -->
        <div class="col-md-7">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Atualizar Perfil</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <?php
            $email = $_SESSION['loginUser'];
            $senha = $_SESSION['senhaUser'];
            $sql = "SELECT * FROM tb_user WHERE email_user =:email AND senha_user =:senha";
            $result = $conexao->prepare($sql);
            $result->bindParam(":email", $email, PDO::PARAM_STR);
            $result->bindParam(":senha", $senha, PDO::PARAM_STR);
            $result->execute();
            $contar = $result->rowCount();
            if ($contar > 0) {
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                ?>
                <form role="" action="" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row["id_user"] ?>" />
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nome</label>
                      <input type="text" class="form-control" id="nome" name="nome" required
                        placeholder="Digite o nome completo" value="<?php echo $row["nome_user"] ?>" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email </label>
                      <input type="email" class="form-control" id="email" name="email" required
                        value="<?php echo $row["email_user"] ?>" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputPassword1">Senha</label>
                      <input type="text" class="form-control" id="senha" name="senha" required
                        autocomplete="current-password" <?php echo "value=" . base64_decode($row["senha_user"]) ?> />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputFile">Foto do contato</label>
                      <br>
                      <!-- <img src="<?php echo "../img/" . $row["foto_user"] ?>" alt="" width="300" height="300"> -->
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="fotocontato" id="fotocontato">
                          value="<?php echo $row["foto_user"] ?>"
                          <label class="custom-file-label" for="exampleInputFile">Arquivo de imagem</label>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" name="atualizarDados" id="atualizarDados"
                      class="btn btn-primary">Atualizar</button>
                  </div>
                </form>
              </div>
              <!-- /.card -->
            </div>
            <!--/.col (left) -->

            <!-- right column -->
            <div class="col-md-5">
              <!-- Form Element sizes -->
              <!-- general form elements disabled -->
              <div class="card">
                <div class="card-header">
                  <!--  <div class="card-header" style=" margin: auto;"> -->
                  <h3 class="card-title">Dados do Perfil</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0" style="text-align: center">
                  <img src="<?php echo "../img/" . $row["foto_user"] ?>" alt="<?php echo $row["foto_user"] ?>"
                    style="width:200px; border-radius:100%; margin-top: 30px">
                  <Br>
                  <h2><?php echo $row["nome_user"] ?></h2>
                  <h5><?php echo $row["email_user"] ?></h5>
                </div>
                <?php
              }
            }
            ?>

          </div>
          <!-- /.card -->
        </div>
        <!-- /.card -->
      </div>
      <!--/.col (right) -->
    </div>
    <!-- /.row -->
</div>
<!-- /.container-fluid -->
</section>
<!-- /.content -->
</div>
<!-- /.content-wrapper -->