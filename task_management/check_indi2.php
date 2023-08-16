<?php
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

function fetchDataFromDatabase($start_date) {
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "task_management";

// ...
$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT md.icode, md.id_count, c.cavity_name, m.mold_name
            FROM merged_data md
            JOIN cavity c ON md.cavity_id = c.cavity_id
            JOIN mold m ON md.mold_id = m.mold_id
            WHERE md.start_date = ?";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("s", $start_date);
// ...

    $stmt->execute();
    $result = $stmt->get_result();

    // Process query results
    $data = [];
    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    // Close the database connection
    $stmt->close();
    $conn->close();

    return $data;
}


if (isset($_POST["export_excel"])) {
    $selected_start_date = $_POST["start_date"];

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $sheet->setCellValue('A1', 'icode');
    $sheet->setCellValue('B1', 'To BE');
    $sheet->setCellValue('C1', 'Cavity');
    $sheet->setCellValue('D1', 'Mold');

    $data = fetchDataFromDatabase($selected_start_date);
// Apply header styles
$headerStyle = [
    'font' => ['bold' => true],
    'alignment' => ['horizontal' => \PhpOffice\PhpSpreadsheet\Style\Alignment::HORIZONTAL_CENTER],
    'fill' => ['fillType' => \PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID, 'startColor' => ['rgb' => 'F8F2F2']],
    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
];
$sheet->getStyle('A1:D1')->applyFromArray($headerStyle);

// Apply data to rows
$dataStyle = [
    'borders' => ['allBorders' => ['borderStyle' => \PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN]],
];
    $rowIndex = 2;
    foreach ($data as $row) {
        $sheet->setCellValue('A' . $rowIndex, $row['icode']);
        $sheet->setCellValue('B' . $rowIndex, $row['id_count']);
        $sheet->setCellValue('C' . $rowIndex, $row['cavity_name']);  // Add cavity_name
        $sheet->setCellValue('D' . $rowIndex, $row['mold_name']);    // Add mold_name
        $sheet->getStyle('A' . $rowIndex . ':D' . $rowIndex)->applyFromArray($dataStyle);
    
        $rowIndex++;
    }
    $filename = "planning.xlsx";
    $writer = new Xlsx($spreadsheet);
    $writer->save($filename);

    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment; filename="' . $filename . '"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
<!-- Include necessary CSS and JavaScript libraries if needed -->
</head>
<body>

<div id="container">
  <h1>Task Management Data</h1>
  <form action="check_indi.php" method="post">
    <label for="start_date">Start Date:</label>
    <input type="date" id="start_date" name="start_date">
    <input type="submit" name="export_excel" value="Export to Excel">
  </form>

</div>

</body>
</html>
