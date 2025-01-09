<?php
include 'config.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $cpf = $_POST['cpf'];
    $rg = $_POST['rg'];
    $email = $_POST['email'];
    $empresa = $_POST['empresa'];
    
    $sql = "INSERT INTO tbl_funcionario (nome, cpf, rg, email, id_empresa, data_cadastro, salario) 
            VALUES ('$nome', '$cpf', '$rg', '$email', '$empresa', CURDATE(), 1000)";
    if ($conn->query($sql) === TRUE) {
        header("Location: home.php"); // Redireciona para a página home
        exit(); // Garante que o script pare após o redirecionamento
    } else {
        echo "Erro ao cadastrar funcionário: " . $conn->error;
    }
}

$sql_empresas = "SELECT * FROM tbl_empresa";
$result_empresas = $conn->query($sql_empresas);
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Funcionário</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <form method="POST" action="">
        <label for="nome">Nome:</label>
        <input type="text" name="nome" required>
        
        <label for="cpf">CPF:</label>
        <input type="text" name="cpf" required>
        
        <label for="rg">RG:</label>
        <input type="text" name="rg" required>
        
        <label for="email">Email:</label>
        <input type="email" name="email" required>
        
        <label for="empresa">Empresa:</label>
        <select name="empresa" required>
            <?php while ($row = $result_empresas->fetch_assoc()): ?>
                <option value="<?= $row['id_empresa'] ?>"><?= $row['nome'] ?></option>
            <?php endwhile; ?>
        </select>
        
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
