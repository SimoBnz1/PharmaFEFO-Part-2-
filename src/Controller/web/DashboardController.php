<?php
// src/Controller/web/DashboardController.php

class DashboardController {
    public function index() {
        ob_start();
        include __DIR__ . '/../../../templates/dashboard/index.php';
        $content = ob_get_clean();
        include __DIR__ . '/../../../templates/layout/base.php';
    }
}