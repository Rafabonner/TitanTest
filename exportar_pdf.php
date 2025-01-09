<?php
require('fpdf.php');
include 'config.php';

$sql = "SELECT * FROM tbl_funcionario";
$result = $conn->query($sql);

$pdf = new FPDF();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 12);

$pdf->Cell(40, 10, 'Nome', 1);
$pdf->Cell(40, 10, 'CPF', 1);
$pdf->Cell(40, 10, 'Email', 1);
$pdf->Cell(40, 10, 'Salario', 1);
$pdf->Ln();

while ($row = $result->fetch_assoc()) {
    $pdf->Cell(40, 10, $row['nome'], 1);
    $pdf->Cell(40, 10, $row['cpf'], 1);
    $pdf->Cell(40, 10, $row['email'], 1);
    $pdf->Cell(40, 10, 'R$ ' . number_format($row['salario'], 2, ',', '.'), 1);
    $pdf->Ln();
}

$pdf->Output();
?>
