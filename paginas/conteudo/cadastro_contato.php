<?php
include('../config/conexao.php');
if (isset($_POST['botao'])) {

  $nome = $_POST['nome'];
  $telefone = $_POST['telefone'];
  $email = $_POST['email'];
  $senha = $_POST['senha'];
  $autoriza = $_POST['autoriza'];
  $formatoIMG = array('png', 'jpg', 'jpeg', 'JPG', 'gif');
  $extensao = pathinfo($_FILES['fotocontato']['name'], PATHINFO_EXTENSION);

  if (in_array($extensao, $formatoIMG)) {
    $pasta = "../img/";
    $temporario = $_FILES['fotocontato']['tmp_name'];
    $novoNome = uniqid() . ".$extensao";

    if (move_uploaded_file($temporario, $pasta . $novoNome)) {

      $cadastro = "INSERT INTO tb_contatos (nome_contatos,fone_contatos,email_contatos,foto_contatos) VALUES (:nome,:telefone,:email,:foto)";

      try {
        $result = $conexao->prepare($cadastro);

        $result->bindParam(":nome", $nome, PDO::PARAM_STR);
        $result->bindParam(":telefone", $telefone, PDO::PARAM_STR);
        $result->bindParam(":email", $email, PDO::PARAM_STR);
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
          /* header("Refresh: 5, home.php"); */
        } else {
          echo '<div class="container">
                                <div class="alert alert-danger alert-dismissible">
                                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                                <h5><i class="icon fas fa-check"></i> Erro!</h5>
                                Dados não inseridos !!!
                              </div>
                            </div>';
          /*   header("Refresh: 5, home.php"); */
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
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
  <!-- Content Header (Page header) -->
  <section class="content-header">
    <div class="container-fluid">
      <div class="row mb-2">
        <div class="col-sm-6">
          <h1>Cadastro de contato</h1>
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
        <div class="col-md-4">
          <!-- general form elements -->
          <div class="card card-primary">
            <div class="card-header">
              <h3 class="card-title">Cadastro</h3>
            </div>
            <!-- /.card-header -->
            <!-- form start -->
            <form role="" action="" method="post" enctype="multipart/form-data">
              <div class="card-body">
                <div class="form-group">
                  <label for="exampleInputEmail1">Nome</label>
                  <input type="text" class="form-control" id="nome" name="nome" required
                    placeholder="Digite o nome completo" />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Telefone</label>
                  <input type="text" class="form-control" id="telefone" name="telefone" required
                    placeholder="(00) 00000-0000" />
                </div>
                <div class="form-group">
                  <label for="exampleInputEmail1">Email </label>
                  <input type="email" class="form-control" id="email" name="email" required
                    placeholder="Digite o Email" />
                </div>
                <div class="form-group">
                  <label for="exampleInputPassword1">Senha</label>
                  <input type="password" class="form-control" id="senha" name="senha" required
                    placeholder="Digite sua senha" autocomplete="current-password" />
                </div>
                <div class="form-group">
                  <label for="exampleInputFile">Foto do contato</label>
                  <div class="input-group">
                    <div class="custom-file">
                      <input type="file" class="custom-file-input" id="fotocontato" name="fotocontato" required />
                      <label class="custom-file-label" for="exampleInputFile">Arquivo de imagen</label>
                    </div>
                  </div>
                </div>
                <div class="form-check">
                  <input type="checkbox" class="form-check-input" id="autoriza" name="autoriza" required />
                  <label class="form-check-label" for="exampleCheck1">Autorizo o cadastro</label>
                </div>
              </div>
              <!-- /.card-body -->
              <div class="card-footer">
                <button type="submit" name="botao" class="btn btn-primary">Cadastrar</button>
              </div>
            </form>
          </div>
          <!-- /.card -->
        </div>
        <!--/.col (left) -->

        <!-- right column -->
        <div class="col-md-8">
          <!-- Form Element sizes -->
          <!-- general form elements disabled -->
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">Contatos rescente</h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body p-0">
              <table class="table table-striped">
                <thead>
                  <tr>
                    <th style="width: 10px">#</th>
                    <th>Nome</th>
                    <th>Telefone</th>
                    <th>Email</th>
                    <th style="width: 40px">Ações</th>
                  </tr>
                </thead>
                <tbody>
                  <?php
                  $dados = "SELECT * FROM `tb_contatos` LIMIT 10";
                  try {
                    $result = $conexao->query($dados);
                    $cont = 1;

                    if ($result->rowCount() > 0) {
                      while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
                        /* echo " Nome : " . $row["nome_contatos"]
                          . " Telefone : " . $row["fone_contatos"]
                          . " Email : " . $row["email_contatos"] . " <br>"; */
                        echo "
                        <tr>
                          <td>" . $cont++ . "</td>
                          <td>" . $row["nome_contatos"] . "</td>
                          <td>" . $row["fone_contatos"] . "</td>
                          <td>" . $row["email_contatos"] . "</td>   
                          <td>
                              <div class='btn-group'>
                                  <a type='button' class='btn btn-info' href='home.php?acao=editar&idUser=" . $row['id_contatos'] . "' title='Editar Contato'>
                                    <i class='bi bi-pencil-square'></i>
                                  </a>
                                  <a type='button' class='btn btn-danger' href='conteudo/delet_contato.php?idUser=" . $row['id_contatos'] . "' 
                                  title='Deletar Contato' onclick=\"return confirm('Desseja remover esse Contato ?')\">
                                    <i class='bi bi-trash'></i>
                                 </a>                                  
                              </div>
                         </td>
                        </tr>";
                      }
                    } else {
                      echo "
                    <tr>
                      <td style='width: 10px'>#</td>
                      <td> # </td>
                      <td # </td>
                      <td>#</td>
                      <td>
                          <div class='btn-group'>
                                  <a type='button' class='btn btn-info' href='home.php?acao=editar' title='Editar Contato'>
                                    <i class='bi bi-pencil-square'></i>
                                  </a>
                                  <a type='button' class='btn btn-danger' href='conteudo/delet_contato.php?idUser=" . $row["id_contatos"] . "' 
                                  title='Deletar Contato' onclick='return confirm('Desseja remover esse Contato ?')'>
                                    <i class='bi bi-trash'></i>
                                 </a>                                  
                              </div>
                     </td>                    
                  </tr> ";
                    }

                  } catch (Exception $e) {
                    echo '<strong>ERRO DE PDO= </strong>' . $e->getMessage();
                  }
                  ?>
                </tbody>
              </table>
            </div>
          </div>
          <!-- /.card -->
          <!-- general form elements disabled -->
          <div class="card card-secondary">

            <!-- /.card-body -->
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