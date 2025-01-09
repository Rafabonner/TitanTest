<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

include 'config.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_funcionario = intval($_POST['id_funcionario']);
    $nome = htmlspecialchars(trim($_POST['nome']));
    $cpf = htmlspecialchars(trim($_POST['cpf']));
    $rg = htmlspecialchars(trim($_POST['rg']));
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $salario = floatval($_POST['salario']);

    // Validação dos dados
    if (empty($id_funcionario) || empty($nome) || empty($cpf) || empty($rg) || empty($email) || empty($salario)) {
        echo "Todos os campos são obrigatórios.";
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo "E-mail inválido.";
        exit();
    }

    // Atualiza os dados do funcionário no banco
    $sql = "UPDATE tbl_funcionario 
            SET nome = ?, cpf = ?, rg = ?, email = ?, salario = ? 
            WHERE id_funcionario = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssdi", $nome, $cpf, $rg, $email, $salario, $id_funcionario);

    if ($stmt->execute()) {
        // Redireciona para a página principal após atualizar
        header('Location: home.php');
        exit();
    } else {
        echo "Erro ao atualizar funcionário: " . $stmt->error;
    }

    $stmt->close();
} else {
    header('Location: home.php');
    exit();
}
?>
