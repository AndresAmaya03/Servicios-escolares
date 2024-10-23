<?php
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

require '../vendor/autoload.php';
require_once "main.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$inputFileName = '/Applications/XAMPP/xamppfiles/htdocs/INVENTARIO-main/caratula_del_expediente.xlsx';

$spreadsheet3 = IOFactory::load($inputFileName);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expediente_id = $_POST['expediente_id'];

    $sheet = $spreadsheet3->getActiveSheet();

    $styleArray = [
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, // Justificación horizontal
            'vertical' => Alignment::VERTICAL_CENTER,     // Justificación vertical
            'wrapText' => true,                                                          // Ajuste de texto
        ],
    ];

    $check_expediente = conexion();
    $numero_expedientes = $check_expediente->query("SELECT COUNT(*) as total FROM expediente");
    $numero_fila = 1;

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
            if($clasificacion_fila['expediente_id'] == $expediente_id) {
                $sheet->setCellValue('F20', $clasificacion_fila['expediente_clasificacion_archivistica']);
                $sheet->setCellValue('B25', $clasificacion_fila['expediente_fecha_apertura']);
                $sheet->setCellValue('D25', $clasificacion_fila['expediente_fecha_cierre']);
                if ($clasificacion_fila['expediente_tradicion_documental'] == 'copia') {
                    $sheet->setCellValue('J25', 'X');
                } else if ($clasificacion_fila['expediente_tradicion_documental'] == 'original') {
                    $sheet->setCellValue('G25', 'X');
                }
                $sheet->setCellValue('B27', $clasificacion_fila['expediente_descripcion']);
                if ($clasificacion_fila['expediente_valor_documental'] == 'administrativo') {
                    $sheet->setCellValue('B33', 'X');
                } else if ($clasificacion_fila['expediente_valor_documental'] == 'legal') {
                    $sheet->setCellValue('D33', 'X');
                } else if ($clasificacion_fila['expediente_valor_documental'] == 'fiscal') {
                    $sheet->setCellValue('F33', 'X');
                } else if ($clasificacion_fila['expediente_valor_documental'] == 'evidencial') {
                    $sheet->setCellValue('B38', 'X');
                } else if ($clasificacion_fila['expediente_valor_documental'] == 'testimonial') {
                    $sheet->setCellValue('C38', 'X');
                } else if ($clasificacion_fila['expediente_valor_documental'] == 'informativo') {
                    $sheet->setCellValue('D38', 'X');
                }
                $sheet->setCellValue('H33', $clasificacion_fila['expediente_tiempo_tramite']);
                $sheet->setCellValue('I33', $clasificacion_fila['expediente_tiempo_concentracion']);
                $sheet->setCellValue('L33', $clasificacion_fila['expediente_tiempo_total']);
                $sheet->setCellValue('H38', $clasificacion_fila['expediente_hojas']);
                $sheet->setCellValue('K38', $clasificacion_fila['expediente_legajos']);
                
            }
            $numero_fila++;
         }
        }
    }


    $filename = "caratula_del_expediente_individual.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer2 = IOFactory::createWriter($spreadsheet3, 'Xlsx');
    $writer2->save('php://output');
    exit;
}
?>

