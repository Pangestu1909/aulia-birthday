<?php

namespace App\Core;

class Controller
{
    /**
     * Render sebuah view di dalam layout header/footer.
     *
     * @param string $view  path view relatif terhadap app/Views, tanpa .php
     * @param array  $data  data yang akan di-extract jadi variabel di view
     */
    protected function render(string $view, array $data = []): void
    {
        extract($data);

        $viewFile = __DIR__ . '/../Views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            http_response_code(500);
            echo "View tidak ditemukan: {$view}";
            return;
        }

        require __DIR__ . '/../Views/layout/header.php';
        require $viewFile;
        require __DIR__ . '/../Views/layout/footer.php';
    }

    protected function redirect(string $path): void
    {
        header('Location: ' . $path);
        exit;
    }
}
