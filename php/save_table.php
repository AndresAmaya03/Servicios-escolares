<?php
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

require '../vendor/autoload.php';
require_once "main.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $spreadsheet = new Spreadsheet(); 
    $sheet = $spreadsheet->getActiveSheet();

    $spreadsheet->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setAutoSize(true);

    $sheet->mergeCells('A1:A2')->setCellValue('A1', "No. Cons");
    $sheet->mergeCells('B1:B2')->setCellValue('B1', "No. de caja");
    $sheet->mergeCells('C1:C2')->setCellValue('C1', "No. secuencial del expediente");
    $sheet->mergeCells('D1:D2')->setCellValue('D1', "Clasificación archivística");
    $sheet->mergeCells('E1:E2')->setCellValue('E1', "Descripción del expediente o asunto");
    $sheet->mergeCells('F1:G1')->setCellValue('F1', "Periodo del trámite del expediente");
    $sheet->setCellValue('F2', "Año de apertura");
    $sheet->setCellValue('G2', "Año de cierre");
    $sheet->mergeCells('H1:J1')->setCellValue('H1', "Vigencia documental");
    $sheet->setCellValue('H2', "AT");
    $sheet->setCellValue('I2', "AC");
    $sheet->setCellValue('J2', "Suma");
    $sheet->mergeCells('K1:M1')->setCellValue('K1', "Clasificación LFTAIPG");
    $sheet->setCellValue('K2', "P");
    $sheet->setCellValue('L2', "R");
    $sheet->setCellValue('M2', "C");
    $sheet->mergeCells('N1:N2')->setCellValue('N1', "No. de Fojas del Exp.");
    $sheet->mergeCells('O1:T1')->setCellValue('O1', "Valor documental");
    $sheet->setCellValue('O2', "A");
    $sheet->setCellValue('P2', "L");
    $sheet->setCellValue('Q2', "F");
    $sheet->setCellValue('R2', "E");
    $sheet->setCellValue('S2', "T");
    $sheet->setCellValue('T2', "I");
    $sheet->mergeCells('U1:V1')->setCellValue('U1', "Traducción documental");
    $sheet->setCellValue('U2', "Original");
    $sheet->setCellValue('V2', "Copia");
    $sheet->mergeCells('W1:Y1')->setCellValue('W1', "TOMOS O LEGAJOS");
    $sheet->setCellValue('W2', "#");
    $sheet->setCellValue('X2', "DE");
    $sheet->setCellValue('Y2', "TOTAL");
    $sheet->mergeCells('Z1:Z2')->setCellValue('Z1', "Observaciones");

    $spreadsheet->getActiveSheet()->getColumnDimension('A')->setWidth(5);
    $spreadsheet->getActiveSheet()->getColumnDimension('B')->setWidth(10);
    $spreadsheet->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    $spreadsheet->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    $spreadsheet->getActiveSheet()->getColumnDimension('E')->setWidth(32);
    $spreadsheet->getActiveSheet()->getColumnDimension('F')->setWidth(16);
    $spreadsheet->getActiveSheet()->getColumnDimension('G')->setWidth(16);
    $spreadsheet->getActiveSheet()->getColumnDimension('H')->setWidth(8);
    $spreadsheet->getActiveSheet()->getColumnDimension('K')->setWidth(8);
    $spreadsheet->getActiveSheet()->getColumnDimension('N')->setWidth(20);
    $spreadsheet->getActiveSheet()->getColumnDimension('O')->setWidth(8);
    $spreadsheet->getActiveSheet()->getColumnDimension('U')->setWidth(12);
    $spreadsheet->getActiveSheet()->getColumnDimension('W')->setWidth(8);
    $spreadsheet->getActiveSheet()->getColumnDimension('Z')->setWidth(15);

    $spreadsheet->getActiveSheet()->getStyle('A1:Z2')->getFont()->setBold(true);

    $styleArray = [
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, // Justificación horizontal
            'vertical' => Alignment::VERTICAL_CENTER,     // Justificación vertical
            'wrapText' => true,                                                          // Ajuste de texto
        ],
    ];

    $spreadsheet->getActiveSheet()->getStyle('A1:Z999')->applyFromArray($styleArray);

    //Inserting exp to excel format
    $check_expediente = conexion();
    $numero_expedientes = $check_expediente->query("SELECT COUNT(*) as total FROM expediente");
    $numero_fila = 3;

    if($numero_expedientes) {
        $fila = $numero_expedientes->fetch();
        $total_expedientes = (int)$fila['total'];
    }
    $check_expediente=null;

    $check_clasificacion = conexion();
    $clasificacion = $check_clasificacion->query("SELECT * FROM expediente");

    for ($i=1; $i <= $total_expedientes; $i++) { 
        if ($clasificacion->rowCount()> 0) {

         while ($clasificacion_fila = $clasificacion->fetch()) {
            $sheet->setCellValue('A'.$numero_fila, $numero_fila - 2);
            $sheet->setCellValue('B'.$numero_fila, "1");
            $sheet->setCellValue('C'.$numero_fila, $numero_fila - 2);
            $sheet->setCellValue('D'.$numero_fila, $clasificacion_fila['expediente_clasificacion_archivistica']);
            $sheet->setCellValue('E'.$numero_fila, $clasificacion_fila['expediente_descripcion']);
            $sheet->setCellValue('F'.$numero_fila, $clasificacion_fila['expediente_fecha_apertura']);
            $sheet->setCellValue('G'.$numero_fila, $clasificacion_fila['expediente_fecha_cierre']);
            $sheet->setCellValue('H'.$numero_fila, $clasificacion_fila['expediente_tiempo_tramite']);
            $sheet->setCellValue('I'.$numero_fila, $clasificacion_fila['expediente_tiempo_concentracion']);
            $sheet->setCellValue('J'.$numero_fila, $clasificacion_fila['expediente_tiempo_total']);
            if ($clasificacion_fila['expediente_clasificacion_LFTAIPG'] == 'publica') {
                $sheet->setCellValue('K'.$numero_fila, "X");
            } else if ($clasificacion_fila['expediente_clasificacion_LFTAIPG'] == 'reservada') {
                $sheet->setCellValue('L'.$numero_fila, "X");
            } else if ($clasificacion_fila['expediente_clasificacion_LFTAIPG'] == 'confidencial') {
                $sheet->setCellValue('M'.$numero_fila, "X");
            }
            $sheet->setCellValue('N'.$numero_fila, $clasificacion_fila['expediente_hojas']);
            if ($clasificacion_fila['expediente_valor_documental'] == 'administrativo') {
                $sheet->setCellValue('O'.$numero_fila, 'X');
            } else if ($clasificacion_fila['expediente_valor_documental'] == 'legal') {
                $sheet->setCellValue('P'.$numero_fila, 'X');
            } else if ($clasificacion_fila['expediente_valor_documental'] == 'fiscal') {
                $sheet->setCellValue('Q'.$numero_fila, 'X');
            } else if ($clasificacion_fila['expediente_valor_documental'] == 'evidencial') {
                $sheet->setCellValue('R'.$numero_fila, 'X');
            } else if ($clasificacion_fila['expediente_valor_documental'] == 'testimonial') {
                $sheet->setCellValue('S'.$numero_fila, 'X');
            } else if ($clasificacion_fila['expediente_valor_documental'] == 'informativo') {
                $sheet->setCellValue('T'.$numero_fila, 'X');
            }
            if ($clasificacion_fila['expediente_tradicion_documental'] == 'original') {
                $sheet->setCellValue('U'.$numero_fila, 'X');
            } else if ($clasificacion_fila['expediente_tradicion_documental'] == 'copia') {
                $sheet->setCellValue('V'.$numero_fila, 'X');
            }
            $sheet->setCellValue('Y'.$numero_fila, $clasificacion_fila['expediente_legajos']);
            $sheet->setCellValue('Z'.$numero_fila, $clasificacion_fila['expediente_observaciones']);
            
            $numero_fila++;
         }
        }
    }

    // Set headers to prompt for download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="tabla_expedientes.xlsx"');
    header('Cache-Control: max-age=0');

    // Save the Excel file to PHP output stream
    $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
    $writer->save('php://output');

    // $spreadsheet2 = new Spreadsheet(); 
    // $sheet2 = $spreadsheet2->getActiveSheet();

    // $spreadsheet2->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

    // $styleArray = [
    //     'alignment' => [
    //         'horizontal' => Alignment::HORIZONTAL_CENTER, // Justificación horizontal
    //         'vertical' => Alignment::VERTICAL_CENTER,     // Justificación vertical
    //         'wrapText' => true,                                                          // Ajuste de texto
    //     ],
    // ];

    // $spreadsheet2->getActiveSheet()->getStyle('A1:Z2')->applyFromArray($styleArray);

    // $check_expediente = conexion();
    // $numero_expedientes = $check_expediente->query("SELECT COUNT(*) as total FROM expediente");
    // $numero_fila = 1;

    // if($numero_expedientes) {
    //     $fila = $numero_expedientes->fetch();
    //     $total_expedientes = (int)$fila['total'];
    // }
    // $check_expediente=null;

    // $check_clasificacion = conexion();
    // $clasificacion = $check_clasificacion->query("SELECT * FROM expediente");

    // for ($i=1; $i <= $total_expedientes; $i++) { 
    //     if ($clasificacion->rowCount()> 0) {

    //      while ($clasificacion_fila = $clasificacion->fetch()) {
    //         $sheet->setCellValue('A'.$numero_fila, $clasificacion_fila['expediente_clasificacion_archivistica']);
    //         $sheet->setCellValue('D'.$numero_fila, $clasificacion_fila['expediente_descripcion']);
    //         $sheet->setCellValue('H'.$numero_fila, $numero_fila);
    //         $numero_fila++;
    //      }
    //     }
    // }


    // $filename = "cejillas.xlsx";
    // header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    // header('Content-Disposition: attachment;filename="'.$filename.'"');
    // header('Cache-Control: max-age=0');

    // $writer2 = IOFactory::createWriter($spreadsheet2, 'Xlsx');
    // $writer2->save('php://output');
    exit;
}
?>

