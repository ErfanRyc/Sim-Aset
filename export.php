<?php
require_once 'function.php';
require_once 'cek.php';
require_once 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Dapatkan koneksi database
// Sesuaikan dengan cara di function.php kamu
$conn = mysqli_connect("localhost", "root", "", "db_barang"); // atau: global $conn;

date_default_timezone_set('Asia/Jakarta');
$today = date('d-m-Y');

// ----------------------------
// FUNGSI EKSPOR (TETAP SAMA)
// ----------------------------

function exportToExcel($data, $headers, $filename) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $col++;
    }

    $lastCol = chr(ord('A') + count($headers) - 1);
    $headerRange = "A1:{$lastCol}1";
    $sheet->getStyle($headerRange)->getFont()->setBold(true);
    $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
    $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle($headerRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

    $row = 2;
    foreach ($data as $item) {
        $col = 'A';
        foreach ($item as $value) {
            $sheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }

    foreach (range('A', $lastCol) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    header('Cache-Control: max-age=0');
    $writer->save('php://output');
    exit;
}

function exportToPDF($data, $headers, $title, $filename) {
    $dompdf = new Dompdf\Dompdf();
    $html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; font-size: 10px; }
            table { width: 100%; border-collapse: collapse; margin: 20px 0; }
            th, td { border: 1px solid #000; padding: 6px; text-align: center; }
            th { background-color: #D3D3D3; }
            h2 { text-align: center; margin-bottom: 20px; }
        </style>
    </head>
    <body>
        <h2>' . htmlspecialchars($title) . '</h2>
        <table>
            <thead><tr>';
    foreach ($headers as $header) {
        $html .= '<th>' . htmlspecialchars($header) . '</th>';
    }
    $html .= '</tr></thead><tbody>';

    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $cell) {
            $html .= '<td>' . htmlspecialchars($cell ?? '-') . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '</tbody></table></body></html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();
    $dompdf->stream($filename . '.pdf', ['Attachment' => 1]);
    exit;
}

// ----------------------------
// AMBIL TIPE EKSPOR
// ----------------------------
$type = $_GET['type'] ?? '';
$page = $_GET['page'] ?? '';

// ----------------------------
// EKSPOR DARI index.php → DAFTAR BARANG
// ----------------------------
if (($type === 'excel' || $type === 'pdf') && ($page === '' || $page === 'barang')) {
    $query = "SELECT 
                    b.namabarang,
                    b.tahun,
                    s.satuan,
                    d.sisa,
                    d.hargasatuan,
                    d.nilaipersediaan,
                    d.keterangan
                FROM detail d
                JOIN barang b ON d.id_barang = b.id_barang
                JOIN addsatuan s ON d.id_satuan = s.id_satuan
                ORDER BY b.namabarang ASC";
    $result = mysqli_query($conn, $query);
    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $data[] = [
            $row['namabarang'],
            $row['tahun'],
            $row['sisa'],
            $row['satuan'],
            "Rp. " . number_format((float)$row['hargasatuan'], 0, ',', '.'),
            "Rp. " . number_format((float)$row['nilaipersediaan'], 0, ',', '.'),
            $row['keterangan']
        ];
    }
    $headers = ['Nama Barang', 'Tahun', 'Stok', 'Satuan', 'Harga Satuan', 'Nilai Akhir Persediaan', 'Keterangan'];
    $title = 'Daftar Barang';
    $filename = 'Daftar Barang ' . $today;

    if ($type === 'excel') {
        exportToExcel($data, $headers, $filename);
    } else {
        exportToPDF($data, $headers, $title, $filename);
    }

// ----------------------------
// EKSPOR DARI laporan.php → LAPORAN BARANG
// ----------------------------
} elseif (($type === 'excel' || $type === 'pdf') && $page === 'laporan') {
    $allowed_types = ['', 'masuk', 'keluar'];
    $tipe = isset($_GET['tipe']) && in_array($_GET['tipe'], $allowed_types) 
            ? $_GET['tipe'] 
            : '';

    $bulan = !empty($_GET['bulan']) ? (int)$_GET['bulan'] : '';
    $tahun = !empty($_GET['tahun']) ? (int)$_GET['tahun'] : '';

    // Tentukan judul dinamis
    if ($tipe === 'masuk') {
        $reportTitle = 'Laporan Barang Masuk';
        $filenameBase = 'Laporan_Barang_Masuk';
    } elseif ($tipe === 'keluar') {
        $reportTitle = 'Laporan Barang Keluar';
        $filenameBase = 'Laporan_Barang_Keluar';
    } else {
        $reportTitle = 'Laporan Barang';
        $filenameBase = 'Laporan_Barang';
    }

    // Sama persis seperti laporan.php
    if ($tipe === 'masuk') {
        $queryFinal = "SELECT 
                           bm.tanggal, 
                           b.namabarang, 
                           s.satuan, 
                           bm.jumlahmasuk,
                           bm.keterangan AS keterangan_masuk
                       FROM barang_masuk bm
                       JOIN detail d ON bm.id_detail = d.id_detail
                       JOIN barang b ON d.id_barang = b.id_barang
                       JOIN addsatuan s ON d.id_satuan = s.id_satuan";
        $where = [];
        if ($bulan) $where[] = "MONTH(bm.tanggal) = $bulan";
        if ($tahun) $where[] = "YEAR(bm.tanggal) = $tahun";
        if (!empty($where)) $queryFinal .= " WHERE " . implode(" AND ", $where);
        $queryFinal .= " ORDER BY tanggal DESC";
        $columns = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk'];
        $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlahmasuk', 'keterangan_masuk'];

    } elseif ($tipe === 'keluar') {
        $queryFinal = "SELECT 
                           bk.tanggal, 
                           b.namabarang, 
                           s.satuan, 
                           bk.jumlahkeluar AS jumlah_keluar,
                           bk.keterangan AS keterangan_keluar
                       FROM barang_keluar bk
                       JOIN detail d ON bk.id_detail = d.id_detail
                       JOIN barang b ON d.id_barang = b.id_barang
                       JOIN addsatuan s ON d.id_satuan = s.id_satuan";
        $where = [];
        if ($bulan) $where[] = "MONTH(bk.tanggal) = $bulan";
        if ($tahun) $where[] = "YEAR(bk.tanggal) = $tahun";
        if (!empty($where)) $queryFinal .= " WHERE " . implode(" AND ", $where);
        $queryFinal .= " ORDER BY tanggal DESC";
        $columns = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Keluar', 'Keterangan Keluar'];
        $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlah_keluar', 'keterangan_keluar'];

    } else {
        $queryMasuk = "SELECT 
                           bm.tanggal, 
                           b.namabarang, 
                           s.satuan, 
                           bm.jumlahmasuk,
                           bm.keterangan AS keterangan_masuk,
                           NULL AS jumlah_keluar,
                           NULL AS keterangan_keluar
                       FROM barang_masuk bm
                       JOIN detail d ON bm.id_detail = d.id_detail
                       JOIN barang b ON d.id_barang = b.id_barang
                       JOIN addsatuan s ON d.id_satuan = s.id_satuan";

        $queryKeluar = "SELECT 
                            bk.tanggal, 
                            b.namabarang, 
                            s.satuan, 
                            NULL AS jumlahmasuk,
                            NULL AS keterangan_masuk,
                            bk.jumlahkeluar AS jumlah_keluar,
                            bk.keterangan AS keterangan_keluar
                        FROM barang_keluar bk
                        JOIN detail d ON bk.id_detail = d.id_detail
                        JOIN barang b ON d.id_barang = b.id_barang
                        JOIN addsatuan s ON d.id_satuan = s.id_satuan";

        $where = [];
        if ($bulan) $where[] = "MONTH(tanggal) = $bulan";
        if ($tahun) $where[] = "YEAR(tanggal) = $tahun";
        if (!empty($where)) {
            $whereStr = " WHERE " . implode(" AND ", $where);
            $queryMasuk .= $whereStr;
            $queryKeluar .= $whereStr;
        }

        $queryFinal = $queryMasuk . " UNION ALL " . $queryKeluar . " ORDER BY tanggal DESC";
        $columns = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk', 'Jumlah Keluar', 'Keterangan Keluar'];
        $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlahmasuk', 'keterangan_masuk', 'jumlah_keluar', 'keterangan_keluar'];
    }

    $result = mysqli_query($conn, $queryFinal);
    if (!$result) {
        die("Query Error: " . mysqli_error($conn));
    }

    $data = [];
    while ($row = mysqli_fetch_assoc($result)) {
        $rowData = [];
        foreach ($data_keys as $key) {
            $value = $row[$key] ?? '-';
            $rowData[] = $value;
        }
        $data[] = $rowData;
    }

    $finalFilename = $filenameBase . ' ' . $today;

    if ($type === 'excel') {
        exportToExcel($data, $columns, $finalFilename);
    } else {
        exportToPDF($data, $columns, $reportTitle, $finalFilename);
    }

} else {
    die('Parameter tidak valid. Gunakan: type=(excel|pdf) dan opsional page=(barang|laporan)');
}