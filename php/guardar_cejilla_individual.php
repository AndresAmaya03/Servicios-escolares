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
    $expediente_id = $_POST['expediente_id'];

    $spreadsheet2 = new Spreadsheet(); 
    $sheet = $spreadsheet2->getActiveSheet();

    $spreadsheet2->getDefaultStyle()->getFont()->setName('Arial')->setSize(10);

    $styleArray = [
        'alignment' => [
            'horizontal' => Alignment::HORIZONTAL_CENTER, // Justificación horizontal
            'vertical' => Alignment::VERTICAL_CENTER,     // Justificación vertical
            'wrapText' => true,                                                          // Ajuste de texto
        ],
    ];

    $spreadsheet2->getActiveSheet()->getStyle('A1:Z999')->applyFromArray($styleArray);

    $check_expediente = conexion();
    $numero_expedientes = $check_expediente->query("SELECT COUNT(*) as total FROM expediente");
    $numero_fila = 1;
    $numero_expediente = 1;

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
                $sheet->mergeCells('A1:C1')->setCellValue('A1', $clasificacion_fila['expediente_clasificacion_archivistica']);
                $sheet->mergeCells('D1:F1')->setCellValue('D1', $clasificacion_fila['expediente_descripcion']);
                $sheet->setCellValue('H1', '1');
                $sheet->getRowDimension('1')->setRowHeight(38.25);
                $sheet->getStyle('H1')->getFill()->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)->getStartColor()->setARGB('FFFFFF00');
                $sheet->getStyle('H1')->getBorders()->getOutline()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THICK)->setColor(new \PhpOffice\PhpSpreadsheet\Style\Color(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLACK));
            }
            $numero_fila++;
         }
        }
    }


    $filename = "cejilla_individual.xlsx";
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="'.$filename.'"');
    header('Cache-Control: max-age=0');

    $writer2 = IOFactory::createWriter($spreadsheet2, 'Xlsx');
    $writer2->save('php://output');
    exit;
}
?>

