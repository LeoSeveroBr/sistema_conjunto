<?php
/* ob_start() */ ;// Armazena os dados em cache
session_start();

if (!isset($_SESSION['loginUser']) && !isset($_SESSION['senhaUser'])) {
    header("Location: ../index.php?acao=negado");
    exit;
}
?>
<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>Agenda Eletronica</title>
    <!--  CDN bootstrap ICON -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback" />
    <!-- DataTables -->
    <link rel="stylesheet" href="../plugins/datatables-bs4/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-responsive/css/responsive.bootstrap4.min.css">
    <link rel="stylesheet" href="../plugins/datatables-buttons/css/buttons.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/1.7.1/css/buttons.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/plug-ins/1.11.3/i18n/pt_br.json">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">


    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="../plugins/fontawesome-free/css/all.min.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.2.3/css/flag-icons.min.css" />
    <!-- Ionicons -->
    <link rel="stylesheet" href="https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css" />
    <!-- Tempusdominus Bootstrap 4 -->
    <link rel="stylesheet" href="../plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css" />
    <!-- iCheck -->
    <link rel="stylesheet" href="../plugins/icheck-bootstrap/icheck-bootstrap.min.css" />
    <!-- JQVMap -->
    <link rel="stylesheet" href="../plugins/jqvmap/jqvmap.min.css" />
    <!-- Theme style -->
    <link rel="stylesheet" href="../dist/css/adminlte.min.css" />
    <!-- overlayScrollbars -->
    <link rel="stylesheet" href="../plugins/overlayScrollbars/css/OverlayScrollbars.min.css" />
    <!-- Daterange picker -->
    <link rel="stylesheet" href="../plugins/daterangepicker/daterangepicker.css" />
    <!-- summernote -->
    <link rel="stylesheet" href="../plugins/summernote/summernote-bs4.min.css" />
    <!-- style CSS -->
    <link rel="stylesheet" href="../dist/css/style.css" />
</head>

<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="../dist/img/AdminLTELogo.png" alt="AdminLTELogo" height="60"
                width="60" />
        </div>
        <?php
        try {
            include_once('../config/conexao.php');
            $email = $_SESSION['loginUser'];
            $senha = $_SESSION['senhaUser'];

            $sql = "SELECT * FROM tb_user WHERE email_user=:email AND senha_user=:senha";
            $prepare = $conexao->prepare($sql);
            $prepare->bindValue(":email", $email, PDO::PARAM_STR);
            $prepare->bindValue(":senha", $senha, PDO::PARAM_STR);
            $prepare->execute();

            // Verifica se há resultados
            if ($prepare->rowCount() > 0) {
                // Itera sobre os resultados
                while ($row = $prepare->fetch(PDO::FETCH_OBJ)) {
                    $nomeUser = $row->nome_user;  // Acessa o nome como propriedade do objeto
                    $fotoUser = $row->foto_user;  // Acessa a foto como propriedade do objeto 
        

                    ?>
                    <!-- Navbar -->
                    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
                        <!-- Left navbar links -->
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
                            </li>
                        </ul>
                        <!-- Right navbar links -->
                        <ul class="navbar-nav ml-auto">
                            <!-- Notifications Dropdown Menu -->
                            <li class="nav-item dropdown">
                                <a class="nav-link" data-toggle="dropdown" href="#" title="Perfil e Sair">
                                    <i class="fa fa-user-circle" aria-hidden="true"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                                    <div class="dropdown-divider"></div>
                                    <a href="home.php?acao=perfil" class="dropdown-item">
                                        <i class="fa fa-user-circle mr-2"></i> Alterar Perfil
                                    </a>
                                    <div class="dropdown-divider"></div>
                                    <a href="../config/logout.php" class="dropdown-item">
                                        <i class="fa fa-sign-out-alt mr-2" aria-hidden="true"></i> Sair
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </nav>
                    <!-- /.navbar -->
                    <!-- Main Sidebar Container -->
                    <aside class="main-sidebar sidebar-dark-primary elevation-4">
                        <!-- Brand Logo -->
                        <a href="#" class="brand-link">
                            <img src="../dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                                style="opacity: 0.8" />
                            <span class="brand-text font-weight-light">Agenda Eletronica</span>
                        </a>
                        <!-- Sidebar -->
                        <div class="sidebar">
                            <!-- Sidebar user panel (optional) -->
                            <div class="user-panel mt-3 pb-3 mb-3 d-flex">
                                <div class="image">
                                    <img src="../img/<?php echo $fotoUser; ?>" class="img-circle elevation-2" alt="User Image" />
                                </div>
                                <div class="info">
                                    <a href="home.php?acao=perfil" class="d-block"><?php echo $nomeUser; ?></a>
                                </div>
                            </div>

                            <!-- Sidebar Menu -->
                            <nav class="mt-2">
                                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                                    data-accordion="false">
                                    <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                                    <li class="nav-item">
                                        <a href="home.php?acao=bemvindo" class="nav-link">
                                            <i class="nav-icon fas fa-tachometer-alt"></i>
                                            <p> Principal</p>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="home.php?acao=relatorio" class="nav-link">
                                            <i class="nav-icon fas fa-chart-pie"></i>
                                            <p> Relatório</p>
                                        </a>
                                    </li>
                                </ul>
                            </nav>
                            <!-- /.sidebar-menu -->
                        </div>
                        <!-- /.sidebar -->
                        <?php
                }
            } else {
                echo "Usuário Não Logado.";
            }

        } catch (PDOException $err) {
            echo $err->getMessage();
        }
        ?>
        </aside>