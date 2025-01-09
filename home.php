<?php
session_start();
if (!isset($_SESSION['usuario'])) {
    header('Location: index.php');
    exit();
}

include 'config.php';

// Consulta com INNER JOIN e aliases claros
$sql = "SELECT 
            a.id_funcionario,
            a.nome AS nome_funcionario,
            a.cpf,
            a.rg,
            a.email,
            a.data_cadastro,
            a.salario,
            b.nome AS nome_empresa
        FROM tbl_funcionario a
        INNER JOIN tbl_empresa b ON a.id_empresa = b.id_empresa";
$result = $conn->query($sql);

// Verifica se a consulta foi executada com sucesso
if (!$result) {
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Funcionários</title>
    <link rel="stylesheet" href="css/home.css">
</head>
<body>
    <header>
        <h1>Bem-vindo, <?= htmlspecialchars($_SESSION['usuario']) ?></h1>       
    </header>

    <div class="container">
    <nav>
            <a href="cadastrar_funcionario.php">Cadastrar Funcionário</a>
            <a href="cadastrar_empresa.php">Cadastrar Empresa</a>
            <a href="logout.php">Sair</a>
        </nav>
        <table>
            <thead>
                <tr>
                    <th>Nome</th>
                    <th>CPF</th>
                    <th>RG</th>
                    <th>Email</th>
                    <th>Empresa</th>
                    <th>Data Cadastro</th>
                    <th>Salário</th>
                    <th>Bonificação</th>
                    <th>Ações</th>
                </tr>
            </thead>
            <tbody>
            <?php while ($row = $result->fetch_assoc()): 
    $dataCadastro = strtotime($row['data_cadastro']);
    $hoje = time();
    $tempoEmpresa = ($hoje - $dataCadastro) / (60 * 60 * 24 * 365);

    
    if ($tempoEmpresa >= 5) {
        $classeLinha = 'red'; 
        $bonificacao = $row['salario'] * 0.20;
    } elseif ($tempoEmpresa >= 1) {
        $classeLinha = 'blue'; 
        $bonificacao = $row['salario'] * 0.10; 
    } else {
        $classeLinha = ''; 
        $bonificacao = 0;
    }
?>
    <tr class="<?= $classeLinha ?>">
        <td><?= htmlspecialchars($row['nome_funcionario']) ?></td>
        <td><?= htmlspecialchars($row['cpf']) ?></td>
        <td><?= htmlspecialchars($row['rg']) ?></td>
        <td><?= htmlspecialchars($row['email']) ?></td>
        <td><?= htmlspecialchars($row['nome_empresa']) ?></td>
        <td><?= date('d/m/Y', strtotime($row['data_cadastro'])) ?></td>
        <td>R$ <?= number_format($row['salario'], 2, ',', '.') ?></td>
        <td>
            R$ <?= number_format($bonificacao, 2, ',', '.') ?>
        </td>
        <td>
            <a href="editar_funcionario.php?id=<?= $row['id_funcionario'] ?>" class="btnEditar">Editar</a> | 
            <a href="excluir_funcionario.php?id=<?= $row['id_funcionario'] ?>" class="btnExcluir">Excluir</a>
        </td>
    </tr>
<?php endwhile; ?>
</tbody>
        </table>
    </div>
</body>
</html>
