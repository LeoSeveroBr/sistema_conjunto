<?php
include('../config/conexao.php');
if (isset($_POST['atualizarCadastro'])) {

  $id = $_POST['id'];
  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $email = $_POST['email'];

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
        $cadastro = "UPDATE `tb_contatos` SET 
                                `nome_contatos` = :nome,
                                `fone_contatos` = :telefone,
                                `email_contatos` = :email,
                                `foto_contatos` = :foto 
                                WHERE `id_contatos` = :id";
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
    $cadastro = "UPDATE `tb_contatos` SET 
                        `nome_contatos` = :nome,
                        `fone_contatos` = :telefone,
                        `email_contatos` = :email
                        WHERE `id_contatos` = :id";
  }

  try {
    $result = $conexao->prepare($cadastro);

    $result->bindParam(":id", $id, PDO::PARAM_INT);
    $result->bindParam(":nome", $nome, PDO::PARAM_STR);
    $result->bindParam(":telefone", $telefone, PDO::PARAM_STR);
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
    } else {
      echo '<div class="container">
                                <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                Dados não inseridos !!!
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
          <h1>Editar contato</h1>
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
              <h3 class="card-title">Atualizar Cadastro</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->

            <?php

            if (isset($_GET['idUser'])) {
              $id = $_GET['idUser'];
              $sql = "SELECT * FROM tb_contatos WHERE id_contatos = " . $id;
              /* var_dump($sql); */
            }


            $result = $conexao->query($sql);
            if ($result->rowCount() > 0) {
              while ($row = $result->fetch(PDO::FETCH_ASSOC)) {

                ?>
                <form role="" action="" method="post" enctype="multipart/form-data">
                  <div class="card-body">
                    <input type="hidden" class="form-control" id="id" name="id" value="<?php echo $row["id_contatos"] ?>" />
                    <div class="form-group">
                      <label for="exampleInputEmail1">Nome</label>
                      <input type="text" class="form-control" id="nome" name="nome" required
                        placeholder="Digite o nome completo" value="<?php echo $row["nome_contatos"] ?>" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Telefone</label>
                      <input type="text" class="form-control" id="telefone" name="telefone" required
                        value="<?php echo $row["fone_contatos"] ?>" />
                    </div>
                    <div class="form-group">
                      <label for="exampleInputEmail1">Email </label>
                      <input type="email" class="form-control" id="email" name="email" required placeholder="Digite o Email"
                        value="<?php echo $row["email_contatos"] ?>" />
                    </div>
                    <!-- <div class="form-group">
                      <label for="exampleInputPassword1">Senha</label>
                      <input type="password" class="form-control" id="senha" name="senha" required
                        placeholder="Digite sua senha" autocomplete="current-password"
                        value="<?php echo $row["nome_contatos"] ?>" />
                    </div> -->
                    <div class="form-group">
                      <label for="exampleInputFile">Foto do contato</label>
                      <br>
                      <!-- <img src="<?php echo "../img/" . $row["foto_contatos"] ?>" alt="" width="300" height="300"> -->
                      <div class="input-group">
                        <div class="custom-file">
                          <input type="file" class="custom-file-input" name="fotocontato" id="fotocontato">
                          value="<?php echo $row["foto_contatos"] ?>"
                          <label class="custom-file-label" for="exampleInputFile">Arquivo de imagem</label>
                          </label>
                        </div>
                      </div>
                    </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                    <button type="submit" name="atualizarCadastro" id="atualizarCadastro" class="btn btn-primary">Atualizar
                      Cadasto</button>
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
                  <h3 class="card-title">Dados Usuario</h3>
                </div>
                <!-- /.card-header -->
                <div class="card-body p-0" style="text-align: center">
                  <img src="<?php echo "../img/" . $row["foto_contatos"] ?>" alt="<?php echo $row["foto_contatos"] ?>"
                    style="width:200px; border-radius:100%; margin-top: 30px">
                  <Br>
                  <h2><?php echo $row["nome_contatos"] ?></h2>
                  <h5><?php echo $row["fone_contatos"] ?></h5>
                  <h5><?php echo $row["email_contatos"] ?></h5>
                </div>


                <?php
              }
            } else {
              echo '<div class="container">
                    <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Erro!</h5>
                    Registro desconhecido, insira um ID correto!!!
                    </div>
                    </div>';
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