<?php
// message.php

// Biar browser tau kita balikin JSON
header('Content-Type: application/json');

// Baca input JSON dari POST
$input = json_decode(file_get_contents('php://input'), true);

// Kalau datanya berhasil dibaca
if ($input) {
    // Contoh: ambil teks pesan
    $message = isset($input['message']) ? $input['message'] : '';

    // Balikin response JSON
    echo json_encode([
        'status' => 'success',
        'reply' => 'Pesan diterima: ' .
