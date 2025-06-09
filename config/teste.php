<?php
require_once 'conexao.php'; // Inclua o arquivo onde sua classe Database está definida

try {
    // Tenta obter a conexão com o banco de dados
    $conexao = Database::getConexao();

    // Executa uma consulta simples para testar a conexão
    $query = $conexao->query("SELECT 'Conexão bem-sucedida!' AS mensagem");
    $resultado = $query->fetch(PDO::FETCH_ASSOC);

    // Exibe o resultado
    echo $resultado['mensagem'];
} catch (PDOException $e) {
    // Exibe a mensagem de erro, caso ocorra
    echo "Erro ao conectar: " . $e->getMessage();
}
