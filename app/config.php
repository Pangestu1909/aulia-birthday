<?php
/**
 * config.php
 * -----------
 * Semua data yang tampil di undangan diatur dari sini.
 * Tinggal ganti nilai di array ini, tidak perlu sentuh kode lain.
 */

return [
    // Identitas acara
    'nama_penerima'   => 'Aulia',
    'usia'            => 23,
    'tanggal_acara'   => '2026-08-02', // format Y-m-d, dipakai untuk hitung mundur
    'tagline'         => 'Happy Level Up Day My Love!!',
    'ucapan_utama'    => 'Happy birthday, my love! I hope you become happier, stronger, and that all your plans and dreams come true.',

    // Dari siapa undangan ini dibuat (opsional, tampil di footer)
    'dari'            => 'My Favorite',

    // Playlist singkat (judul saja, dipakai untuk elemen dekoratif "now playing")
    'lagu'            => 'Happy Birthday To You',

    'kata_kata' => [
        'Thank you for being here and for being part of so many beautiful chapters of my life.',
        'I hope only good things come your way, my love, today and always.',
        'Stay the Aulia I know strong, warm, and always bringing happiness wherever you go.',
        'May all your beautiful dreams slowly come true.',
        'I LOVE YOU SAYANG '
    ],  
    // Foto-foto di galeri/scrapbook.
    // 'src' cukup nama file di public/img/ (silakan ganti dengan foto asli).
    // 'caption' muncul di bawah foto saat di-hover/klik.
    'foto' => [
    [
        'src' => 'Kolase/foto-12.jpg',
        'caption' => '',
    ],
    [
        'src' => 'Kolase/foto-7.jpg',
        'caption' => '',
    ],
    [
        'src' => 'Kolase/foto-8.jpg',
        'caption' => '',
    ],
    [
        'src' => 'Kolase/foto-9.jpg',
        'caption' => '',
    ],
    [
        'src' => 'Kolase/foto-10.jpg',
        'caption' => '',
    ],
    [
        'src' => 'Kolase/foto-11.jpg',
        'caption' => '',
    ],

],
];

