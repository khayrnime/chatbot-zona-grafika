<?php
// message.php

// Biar browser tau balasannya JSON
header('Content-Type: application/json');

// Baca input JSON dari POST
$input = json_decode(file_get_contents('php://input'), true);

// Kalau ada datanya
if ($input) {
    $message = isset($input['message']) ? strtolower(trim($input['message'])) : '';
    
    // Cek isi message dan buat auto-reply
    if ($message == 'halo') {
        $reply = 'Hai juga! Ada yang bisa kami bantu?';
    } elseif ($message == 'harga') {
        $reply = 'Harga produk kami mulai dari 1000 per cup!';
    } else {
        $reply = 'Maaf, saya tidak mengerti. Ketik "halo" atau "harga".';
    }

    // Balikin response
    echo json_encode([
        'status' => 'success',
        'reply' => $reply
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Data tidak valid'
    ]);
}
?>
