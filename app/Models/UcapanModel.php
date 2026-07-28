<?php

namespace App\Models;

/**
 * UcapanModel
 * -----------
 * Menyimpan ucapan/komentar tamu ke storage/ucapan.json.
 * Sengaja pakai file JSON (bukan database) supaya proyek ini
 * langsung jalan tanpa perlu setup MySQL. Kalau butuh skala lebih
 * besar, tinggal ganti isi class ini dengan query PDO.
 */
class UcapanModel
{
    private string $file;

    public function __construct()
    {
        $this->file = __DIR__ . '/../../storage/ucapan.json';

        if (!file_exists($this->file)) {
            file_put_contents($this->file, json_encode([]));
        }
    }

    public function getAll(): array
    {
        $json = file_get_contents($this->file);
        $data = json_decode($json, true) ?: [];

        // Terbaru di atas
        return array_reverse($data);
    }

    public function add(string $nama, string $pesan): void
    {
        $data = json_decode(file_get_contents($this->file), true) ?: [];

        $data[] = [
            'nama'  => $nama,
            'pesan' => $pesan,
            'waktu' => date('Y-m-d H:i:s'),
        ];

        file_put_contents($this->file, json_encode($data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}
