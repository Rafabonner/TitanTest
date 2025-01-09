<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'config.php';
    
    // Sanitizar os dados de entrada
    $login = $conn->real_escape_string($_POST['login']);
    $senha = md5($_POST['senha']); // A senha é convertida para MD5

    // Preparando a consulta
    $stmt = $conn->prepare("SELECT * FROM tbl_usuario WHERE login = ? AND senha = ?");
    $stmt->bind_param("ss", $login, $senha); // 'ss' indica que os dois parâmetros são do tipo string
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Login bem-sucedido
        $_SESSION['usuario'] = $login;
        header('Location: home.php');
        exit(); // Sempre use exit após redirecionamento
    } else {
        // Erro de login
        $erro = "Email ou senha incorretos.";
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/index.css">
</head>
<body>
    
    <form method="POST" action="">
        <h2>Login</h2>
        <label for="login">Email:</label>
        <input type="email" name="login" required>
        
        <label for="senha">Senha:</label>
        <input type="password" name="senha" required>
        
        <button type="submit">Entrar</button>
    </form>
    
    <!-- Exibindo a mensagem de erro, se houver -->
    <?php if (isset($erro)) echo "<p style='color: red;'>$erro</p>"; ?>
</body>
</html>
