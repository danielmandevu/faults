<?php
    require_once 'fpdf.php';
    require_once '../db.php';
    $date = array();
    $date_from = '01/01/2022';
    $date_to = date('d/m/y', time());
    if(isset($_GET['from']) && $_GET['from'] != ""){
        $date_from = $_GET['from'];
    }
    if(isset($_GET['to']) && $_GET['to'] != ""){
        $date_to = $_GET['to'];
    }
    $date_to = strtotime($date_to);
    $date_to = date('Y-m-d', $date_to);
    $date_from = strtotime($date_from);
    $date_from = date('Y-m-d', $date_from);
    $total = '';
    $pending_num = '';
    $cleared_num = '';
    $total_reported =  '';
    $total_reads = 0;
    $res = mysqli_query($conn, "SELECT COUNT(fault_id) AS total, (SELECT COUNT(fault_id) FROM faults WHERE fault_status = 'pending' AND date_reported <= '$date_to' AND date_reported >= '$date_from') AS pending_num, (SELECT COUNT(fault_id) FROM faults WHERE fault_status = 'Cleared' AND date_cleared <= '$date_to' AND date_cleared >= '$date_from') AS cleared_num FROM `faults` WHERE date_reported <= '$date_to' AND date_reported >= '$date_from'");
    while ($row = mysqli_fetch_array($res)) {
        $total = $row['total'];
        $pending_num = $row['pending_num'];
        $cleared_num = $row['cleared_num'];
    }
    $res_total_reads = mysqli_query($conn, "SELECT SUM(readsNum) AS totalReads FROM `knowledge_articles`");
    while($row = mysqli_fetch_array($res_total_reads)){
        $total_reads = $row['totalReads'];
    }
    class PDF extends FPDF
{
// Page header
function Header()
{
    // Logo
    $this->Image('Q_Ak8MlI_400x400.jpg',5,6,30);
    // Arial bold 15
    $this->SetFont('Arial','B',15);
    // Move to the right
    $this->Cell(80);
    // Title
    $this->Cell(30,10,'Mzuzu City Faults And Complaints Reporting',0,0,'C');
    // Line break
    $this->Ln(20);
}

// Page footer
function Footer()
{
    // Position at 1.5 cm from bottom
    $this->SetY(-15);
    // Arial italic 8
    $this->SetFont('Arial','I',8);
    // Page number
    $this->Cell(0,10,'Page '.$this->PageNo().'/{nb}',0,0,'C');
}
}

// Instanciation of inherited class
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Times','',12);
$pdf->Cell(0,10,'Total Reports Received:'.$total,0,1);
$pdf->Cell(0,10,'Total Reports Pending:'.$pending_num,0,1);
$pdf->Cell(0,10,'Total Reports Cleared:'.$cleared_num,0,1);
$pdf->Cell(0,10,'Total Knowledge Area Reads:'.$total,0,1);
$pdf->Output();

?>