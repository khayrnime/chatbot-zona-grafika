<?php
// Baca data POST dari WhatsAuto
$data = json_decode(file_get_contents('php://input'), true);

$message = isset($data['message']) ? strtolower(trim($data['message'])) : '';
$sender = isset($data['sender']) ? $data['sender'] : '';

// URL Spreadsheet CSV
$sheet_url = 'https://docs.google.com/spreadsheets/d/e/2PACX-1vQvZVJcKXODf2525zwRQ1E9zu3LPaSJ0LjXQrRtq2a17nLi8UcB2_7I1eH1S--6KsR0CrB2ft4wvf5z/pub?output=csv';

// Ambil data dari spreadsheet
$csv_data = @file_get_contents($sheet_url);
if ($csv_data === false) {
    echo json_encode(['reply' => 'Gagal mengambil data Spreadsheet.']);
    exit;
}

$rows = array_map('str_getcsv', explode("\n", $csv_data));
$header = array_map('trim', array_shift($rows));

$sheet_data = [];
foreach ($rows as $row) {
    if (count($row) == count($header)) {
        $sheet_data[] = array_combine($header, $row);
    }
}

// Cek keyword dari pesan
$response = 'Maaf, data tidak ditemukan.';
foreach ($sheet_data as $item) {
    if (isset($item['keyword']) && strtolower(trim($item['keyword'])) === $message) {
        $response = "Nama Produk: " . $item['nama'] . "\nHarga: " . $item['harga'];
        break;
    }
}

// Kirim balasan dalam format JSON
echo json_encode([
    'reply' => $response
]);
?>
