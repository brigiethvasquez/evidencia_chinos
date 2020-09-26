<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Codedge\Fpdf\Fpdf\Fpdf;
use App\Artista;
class PDFController extends Controller
{
    public function index(){
        $pdf = new Fpdf();
        $pdf->AddPage();
        $pdf->SetXY(10,10);
        $pdf->SetFont('Arial','b',14);
        $pdf->SetDrawColor(200,0,0);
        $pdf->SetTextColor(0,0,200);
        $pdf->Cell(110,10,"Nombre artista",1,0,"C");
  
        $pdf->Cell(50,10,utf8_decode("Número de albun"),1,1,"C");
        $pdf->SetDrawColor(0,0,200);
        $pdf->SetTextColor(200,0,0);
        $artistas= Artista::all();
        $pdf->SetFont('Arial','I',11);
        foreach($artistas as $a){
            $pdf->Cell(110,10,substr(utf8_decode($a->Name),0,50),1,0,"L");
            $pdf->Cell(50,10,$a->albumes()->count(),1,1,"C");
        }
        $response = response($pdf->Output());
        $response->header("Content-Type",'application/pdf');
        return $response;


    }
}
