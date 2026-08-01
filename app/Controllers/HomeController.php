<?php

namespace App\Controllers;

use App\Core\Controller;
use App\Models\UcapanModel;

class HomeController extends Controller
{
    private UcapanModel $ucapanModel;

    public function __construct()
    {
        $this->ucapanModel = new UcapanModel();
    }

    /**
     * Halaman utama undangan.
     */
    public function index(): void
    {
        $zonaWaktu = new \DateTimeZone('Asia/Jakarta');

        $waktuSekarang = new \DateTimeImmutable(
            'now',
            $zonaWaktu
        );

        $waktuDibuka = new \DateTimeImmutable(
            '2026-08-02 00:00:00',
            $zonaWaktu
        );

        if ($waktuSekarang < $waktuDibuka) {
            header(
                'Cache-Control: no-store, no-cache, must-revalidate, max-age=0'
            );

            echo 'QR ini baru dapat dibuka pada 2 Agustus 2026 pukul 00.00 WIB.';

            return;
        }

        $config = require __DIR__ . '/../config.php';
        $ucapan = $this->ucapanModel->getAll();
        $flash = $_SESSION['flash'] ?? null;

        unset($_SESSION['flash']);

        $this->render('home/index', [
            'config' => $config,
            'ucapan' => $ucapan,
            'flash' => $flash,
        ]);
    }

    /**
     * Simpan ucapan baru dari form guestbook, lalu redirect kembali.
     */
    public function kirimUcapan(): void
    {
        $nama = trim($_POST['nama'] ?? '');
        $pesan = trim($_POST['pesan'] ?? '');

        if ($nama === '' || $pesan === '') {
            $_SESSION['flash'] = [
                'type' => 'error',
                'text' => 'Nama dan ucapan tidak boleh kosong ya.',
            ];

            $this->redirect('/#tinggalkan-ucapan');

            return;
        }

        $nama = htmlspecialchars(
            $nama,
            ENT_QUOTES,
            'UTF-8'
        );

        $pesan = htmlspecialchars(
            $pesan,
            ENT_QUOTES,
            'UTF-8'
        );

        $this->ucapanModel->add($nama, $pesan);

        $_SESSION['flash'] = [
            'type' => 'success',
            'text' => 'Makasih ucapannya, ' . $nama . '!',
        ];

        $this->redirect('/#dinding-ucapan');
    }
}