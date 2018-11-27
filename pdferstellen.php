<?php
 include 'sessionHandling.php';
    $sh = sessionHandling::Instance();
        $sh->open_session(); //vorhandene session übernehmen
        $sh->regenerate_session_id();
        $sh->isCorrectPape("abwart");


require("fpdf.php");
$db = new PDO('mysql:host=eu-cdbr-west-02.cleardb.net;dbname=heroku_264d8c0ac2b1d8d','b46bd03f9f4fdf','cb61f804');
$userId = $_GET['id'];



class myPDF extends FPDF{
    function header(){
        
        $this->SetFont('Arial','B',14);
        $this->Cell(276,5,'Pretzel Real Estate Inc.',0,0,'C');
        $this->Ln();
        $this->SetFont('Times','',12);
        $this->Cell(276,10,'Rechnung',0,0,'C');
        $this->Ln(20);
    }
    function headerTable(){
        $this->SetFont('Times','B',12);
        $this->Cell(20,10,'ID',1,0,'C');
        $this->Cell(40,10,'Rechnungtyp',1,0,'C');
        $this->Cell(40,10,'Status',1,0,'C');
        $this->Cell(40,10,'Betrag',1,0,'C');
        $this->Cell(36,10,'User-ID',1,0,'C');
        $this->Ln();
    }
    function viewTable($db, $userId){
        $this->SetFont('Times','',12);
        $stmt = $db->query("select * from rechnung WHERE fk_userId = '$userId'");
        while($data = $stmt->fetch(PDO::FETCH_OBJ)){
            $this->Cell(20,10,$data->id,1,0,'L');
            $this->Cell(40,10,$data->rechnungstyp,1,0,'L');
            $this->Cell(40,10,$data->status,1,0,'L');
            $this->Cell(40,10,$data->betrag,1,0,'L');
            $this->Cell(36,10,$data->fk_userId,1,0,'L');
            $this->Ln();
        }
        
    }
}
$pdf = new myPDF();
$pdf->AliasNbPages();
$pdf->AddPage('L','A4',0);
$pdf->headerTable();
$pdf->viewTable($db, $userId);
$pdf->Output();

?>

