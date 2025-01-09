<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'config.php';
    
    $nome = $_POST['nome'];
    
    $sql = "INSERT INTO tbl_empresa (nome) VALUES ('$nome')";
    if ($conn->query($sql) === TRUE) {
        header('Location: home.php');
        exit; 
    } else {
        echo "Erro ao cadastrar empresa: " . $conn->error;
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastrar Empresa</title>
    <link rel="stylesheet" href="css/forms.css">
</head>
<body>
    <form method="POST" action="">
        <label for="nome">Nome da Empresa:</label>
        <input type="text" name="nome" required>
        <button type="submit">Cadastrar</button>
    </form>
</body>
</html>
