<?php
include("../../config/conexao.php");

if (isset($_GET["idUser"])) {
    $id = $_GET["idUser"];
    $sql = "DELETE FROM tb_contatos WHERE id_contatos = :id_contatos";

    try {        
        $prepare = $conexa->prepare($sql);
        $prepare->bindParam(":id_contatos", $id, PDO::PARAM_INT);
        $prepare->execute();

        $result = $prepare->rowCount();

        if ($result > 0) {
            header("location: ../home.php");
        } else {
            header("location: ../home.php");
        }

    } catch (PDOException $e) {
        echo "ERRO AO DELETAR " . $e->getMessage() . ".";
    }

}
