<?php
// Verificação do idUser e redirecionamento, se necessário
if (isset($_GET['acao']) && $_GET['acao'] == 'editar' && empty($_GET['idUser'])) {
    header('Location: home.php?acao=bemvindo'); // Redireciona para uma página padrão
    exit();
}

// Incluir o cabeçalho
include_once("../includes/header.php");

// Lógica para carregar o conteúdo baseado na ação
if (isset($_GET['acao'])) {
    $acao = $_GET['acao'];
    if ($acao == 'bemvindo') {
        include_once("conteudo/cadastro_contato.php");
    } elseif ($acao == 'editar') {
        include_once("conteudo/editar_contato.php");
    } elseif ($acao == 'relatorio') {
        include_once("conteudo/relatorio.php");
    } elseif ($acao == 'perfil') {
        include_once("conteudo/editar_perfil.php");
    }
} else {
    include_once("conteudo/cadastro_contato.php");
}

// Incluir o rodapé
include_once("../includes/footer.php");