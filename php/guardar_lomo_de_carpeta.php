<?php
ini_set('display_errors', 'On');
ini_set('error_reporting', E_ALL);

require '../vendor/autoload.php';
require_once "main.php";

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

$inputFileName = '/Applications/XAMPP/xamppfiles/htdocs/INVENTARIO-main/lomo_de_carpeta.xlsx';

$spreadsheet2 = IOFactory::load($inputFileName);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $expediente_id = $_POST['expediente_id'];

    $sheet = $spreadsheet2->getActiveSheet();

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
                $sheet->setCellValue('A22', $clasificacion_fila['expediente_descripcion']);
                $sheet->setCellValue('A32', $clasificacion_fila['expediente_clasificacion_archivistica']);
            }
            $numero_fila++;
         }
        }
    }


    $filename = "lomo_de_carpeta_individual.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer2 = IOFactory::createWriter($spreadsheet2, 'Xlsx');
    $writer2->save('php://output');
    exit;
}
?>

