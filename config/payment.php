<?php

return [
    'method' => 'Virtual Account Bank Transfer',

    // Batas waktu (menit) untuk mengunggah bukti pembayaran sebelum pendaftaran otomatis kadaluarsa.
    'proof_timeout_minutes' => 1,

    'accounts' => [
        [
            'bank' => 'BCA',
            'number' => '1234567890',
            'name' => 'Kreasi Hangat',
            'branch' => 'Jakarta',
            'notes' => 'Gunakan nomor referensi pada catatan transfer bila diperlukan.',
            'is_primary' => true,
        ],
    ],
];
