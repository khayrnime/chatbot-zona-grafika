<?php
// Baca JSON POST dari WhatsAuto
$data = json_decode(file_get_contents('php://input'), true);

// Ambil message dan sender
$message = isset($data['message']) ? strtolower(trim($data['message'])) : '';
$sender = isset($data['sender']) ? $data['sender'] : '';

$response = '';

// Contoh Auto Reply
if ($message === 'halo') {
    $response = 'Hai juga! Ada yang bisa kami bantu?';
} elseif ($message === 'harga') {
    $response = 'Harga produk kami mulai dari 1000 per cup!';
} else {
    $response = 'Maaf, saya tidak paham. Coba ketik "halo" atau "harga".';
}

// Balas dalam format JSON
echo json_encode([
    'reply' => $response
]);
?>
