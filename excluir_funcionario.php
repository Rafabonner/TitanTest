<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['id'])) {
    $id_funcionario = intval($_GET['id']);

    // Exclui o funcionário do banco de dados
    $sql = "DELETE FROM tbl_funcionario WHERE id_funcionario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id_funcionario);

    if ($stmt->execute()) {
        // Redireciona de volta para a página principal após excluir
        header('Location: home.php');
        exit();
    } else {
        echo "Erro ao excluir funcionário.";
    }
} else {
    // Caso o ID não seja fornecido, redireciona de volta
    header('Location: home.php');
    exit();
}
?>
