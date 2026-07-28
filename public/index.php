<?php

/**
 * public/index.php
 * -----------------
 * Front controller. Semua request masuk lewat sini (lihat .htaccess).
 */

session_start();

require __DIR__ . '/../app/Core/Router.php';
require __DIR__ . '/../app/Core/Controller.php';
require __DIR__ . '/../app/Models/UcapanModel.php';
require __DIR__ . '/../app/Controllers/HomeController.php';

use App\Core\Router;
use App\Controllers\HomeController;

$router = new Router();

$router->get('/', [HomeController::class, 'index']);
$router->post('/kirim-ucapan', [HomeController::class, 'kirimUcapan']);

$router->dispatch($_SERVER['REQUEST_METHOD'], $_SERVER['REQUEST_URI']);
