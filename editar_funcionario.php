<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

include 'config.php';

if (!isset($_GET['id'])) {
    header('Location: home.php');
    exit();
}

$id_funcionario = intval($_GET['id']);

// Busca os dados do funcionário pelo ID
$sql = "SELECT * FROM tbl_funcionario WHERE id_funcionario = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id_funcionario);
$stmt->execute();
$result = $stmt->get_result();
$funcionario = $result->fetch_assoc();

if (!$funcionario) {
    header('Location: home.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Funcionário</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <form action="atualizar_funcionario.php" method="POST">
        <h2>Editar Funcionário</h2>
        <input type="hidden" name="id_funcionario" value="<?= $funcionario['id_funcionario'] ?>">
        
        <label for="nome">Nome:</label>
        <input type="text" name="nome" id="nome" value="<?= htmlspecialchars($funcionario['nome']) ?>" required>
        
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" id="cpf" value="<?= htmlspecialchars($funcionario['cpf']) ?>" required>
        
        <label for="rg">RG:</label>
        <input type="text" name="rg" id="rg" value="<?= htmlspecialchars($funcionario['rg']) ?>" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?= htmlspecialchars($funcionario['email']) ?>" required>
        
        <label for="salario">Salário:</label>
        <input type="number" name="salario" id="salario" value="<?= htmlspecialchars($funcionario['salario']) ?>" step="0.01" required>
        
        <button type="submit">Salvar Alterações</button>
    </form>
</body>
</html>

