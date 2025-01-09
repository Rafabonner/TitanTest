<?php
$host = "localhost";
$user = "root";
$password = "";
$dbname = "sistema";

// Criando a conexão com o banco de dados
$conn = new mysqli($host, $user, $password, $dbname);

// Verificando a conexão
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}
?>
