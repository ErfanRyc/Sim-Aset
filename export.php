<?php
require_once 'function.php'; // Untuk koneksi database
require_once 'cek.php';     // Jika ada validasi login
require_once 'vendor/autoload.php'; // Wajib ada!

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

// Dapatkan tanggal cetak dalam format DD-MM-YYYY
$today = date('d-m-Y');

// Fungsi untuk mengekspor ke Excel
function exportToExcel($data, $headers, $filename) {
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    // Header
    $col = 'A';
    foreach ($headers as $header) {
        $sheet->setCellValue($col . '1', $header);
        $col++;
    }

    // Styling Header
    $headerRange = 'A1:' . chr(ord('A') + count($headers) - 1) . '1';
    $sheet->getStyle($headerRange)->getFont()->setBold(true);
    $sheet->getStyle($headerRange)->getFill()->setFillType(Fill::FILL_SOLID)->getStartColor()->setRGB('D3D3D3');
    $sheet->getStyle($headerRange)->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
    $sheet->getStyle($headerRange)->getBorders()->getBottom()->setBorderStyle(Border::BORDER_THIN);

    // Data
    $row = 2;
    foreach ($data as $item) {
        $col = 'A';
        foreach ($item as $value) {
            $sheet->setCellValue($col . $row, $value);
            $col++;
        }
        $row++;
    }

    // Auto-size columns
    foreach (range('A', $col) as $columnID) {
        $sheet->getColumnDimension($columnID)->setAutoSize(true);
    }

    $writer = new Xlsx($spreadsheet);

    // Set header untuk download
    header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
    header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
    header('Cache-Control: max-age=0');

    $writer->save('php://output');
    exit;
}

// Fungsi untuk mengekspor ke PDF (menggunakan DomPDF)
function exportToPDF($data, $headers, $title, $filename) {
    $dompdf = new Dompdf\Dompdf();

    // Buat HTML untuk PDF
    $html = '
    <html>
    <head>
        <style>
            body { font-family: Arial, sans-serif; }
            table { width: 100%; border-collapse: collapse; margin-top: 20px; }
            th, td { border: 1px solid #000; padding: 8px; text-align: center; }
            th { background-color: #D3D3D3; }
            h2 { text-align: center; }
        </style>
    </head>
    <body>
        <h2>' . $title . '</h2>
        <table>
            <thead>
                <tr>';
    foreach ($headers as $header) {
        $html .= '<th>' . $header . '</th>';
    }
    $html .= '
                </tr>
            </thead>
            <tbody>';

    foreach ($data as $row) {
        $html .= '<tr>';
        foreach ($row as $cell) {
            $html .= '<td>' . htmlspecialchars($cell) . '</td>';
        }
        $html .= '</tr>';
    }
    $html .= '
            </tbody>
        </table>
    </body>
    </html>';

    $dompdf->loadHtml($html);
    $dompdf->setPaper('A4', 'landscape');
    $dompdf->render();

    // Output PDF dengan nama file yang berisi tanggal
    $dompdf->stream($filename . '.pdf', ['Attachment' => 1]);
    exit;
}

// Ambil parameter dari URL
$type = $_GET['type'] ?? '';
$page = $_GET['page'] ?? '';

// Proses berdasarkan halaman
if ($type === 'excel') {
    if ($page === 'barang' || $page === '') {
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
                'Nama Barang' => $row['namabarang'],
                'Tahun' => $row['tahun'],
                'Sisa' => $row['sisa'],
                'Satuan' => $row['satuan'],
                'Harga Satuan' => "Rp. " . number_format((float)$row['hargasatuan'], 0, ',', '.'),
                'Nilai Akhir Persediaan' => "Rp. " . number_format((float)$row['nilaipersediaan'], 0, ',', '.'),
                'Keterangan' => $row['keterangan']
            ];
        }
        $headers = ['Nama Barang', 'Tahun', 'Sisa', 'Satuan', 'Harga Satuan', 'Nilai Akhir Persediaan', 'Keterangan'];
        exportToExcel($data, $headers, 'Daftar Barang ' . $today);
    } elseif ($page === 'laporan') {
        // --- SESUAIKAN DENGAN LOGIKA LAPORAN.PHP ---
        $allowed_types = ['', 'masuk', 'keluar'];
        $tipe = in_array($_GET['tipe'] ?? '', $allowed_types) ? $_GET['tipe'] : '';

        $bulan = !empty($_GET['bulan']) ? (int)$_GET['bulan'] : '';
        $tahun = !empty($_GET['tahun']) ? (int)$_GET['tahun'] : '';

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

            if (!empty($where)) {
                $queryFinal .= " WHERE " . implode(" AND ", $where);
            }

            $queryFinal .= " ORDER BY tanggal DESC";
            $headers = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk'];
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

            if (!empty($where)) {
                $queryFinal .= " WHERE " . implode(" AND ", $where);
            }

            $queryFinal .= " ORDER BY tanggal DESC";
            $headers = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Keluar', 'Keterangan Keluar'];
            $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlah_keluar', 'keterangan_keluar'];

        } else { // Semua
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

            $queryFinal = $queryMasuk . " UNION ALL " . $queryKeluar;
            $queryFinal .= " ORDER BY tanggal DESC";
            $headers = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk', 'Jumlah Keluar', 'Keterangan Keluar'];
            $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlahmasuk', 'keterangan_masuk', 'jumlah_keluar', 'keterangan_keluar'];
        }

        $result = mysqli_query($conn, $queryFinal);
        if (!$result) {
            die("Query Error: " . mysqli_error($conn));
        }

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $rowData = [];
            foreach ($data_keys as $key) {
                $value = $row[$key] ?? '-';
                // Format rupiah jika nama kolom mengandung "hargasatuan" atau "nilaipersediaan"
                if (strpos($key, 'hargasatuan') !== false || strpos($key, 'nilaipersediaan') !== false) {
                    $value = "Rp. " . number_format((float)$value, 0, ',', '.');
                }
                $rowData[] = $value;
            }
            $data[] = $rowData;
        }

        exportToExcel($data, $headers, 'Laporan Barang ' . $today);
    }
} elseif ($type === 'pdf') {
    if ($page === 'barang' || $page === '') {
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
        $headers = ['Nama Barang', 'Tahun', 'Sisa', 'Satuan', 'Harga Satuan', 'Nilai Akhir Persediaan', 'Keterangan'];
        exportToPDF($data, $headers, 'Daftar Barang', 'Daftar Barang ' . $today);
    } elseif ($page === 'laporan') {
        // --- SESUAIKAN DENGAN LOGIKA LAPORAN.PHP ---
        $allowed_types = ['', 'masuk', 'keluar'];
        $tipe = in_array($_GET['tipe'] ?? '', $allowed_types) ? $_GET['tipe'] : '';

        $bulan = !empty($_GET['bulan']) ? (int)$_GET['bulan'] : '';
        $tahun = !empty($_GET['tahun']) ? (int)$_GET['tahun'] : '';

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

            if (!empty($where)) {
                $queryFinal .= " WHERE " . implode(" AND ", $where);
            }

            $queryFinal .= " ORDER BY tanggal DESC";
            $headers = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk'];
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

            if (!empty($where)) {
                $queryFinal .= " WHERE " . implode(" AND ", $where);
            }

            $queryFinal .= " ORDER BY tanggal DESC";
            $headers = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Keluar', 'Keterangan Keluar'];
            $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlah_keluar', 'keterangan_keluar'];

        } else { // Semua
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

            $queryFinal = $queryMasuk . " UNION ALL " . $queryKeluar;
            $queryFinal .= " ORDER BY tanggal DESC";
            $headers = ['Tanggal', 'Nama Barang', 'Satuan', 'Jumlah Masuk', 'Keterangan Masuk', 'Jumlah Keluar', 'Keterangan Keluar'];
            $data_keys = ['tanggal', 'namabarang', 'satuan', 'jumlahmasuk', 'keterangan_masuk', 'jumlah_keluar', 'keterangan_keluar'];
        }

        $result = mysqli_query($conn, $queryFinal);
        if (!$result) {
            die("Query Error: " . mysqli_error($conn));
        }

        $data = [];
        while($row = mysqli_fetch_assoc($result)){
            $rowData = [];
            foreach ($data_keys as $key) {
                $value = $row[$key] ?? '-';
                // Format rupiah jika nama kolom mengandung "hargasatuan" atau "nilaipersediaan"
                if (strpos($key, 'hargasatuan') !== false || strpos($key, 'nilaipersediaan') !== false) {
                    $value = "Rp. " . number_format((float)$value, 0, ',', '.');
                }
                $rowData[] = $value;
            }
            $data[] = $rowData;
        }

        exportToPDF($data, $headers, 'Laporan Barang', 'Laporan Barang ' . $today);
    }
} else {
    die('Tipe ekspor tidak valid. Gunakan type=excel atau type=pdf.');
}