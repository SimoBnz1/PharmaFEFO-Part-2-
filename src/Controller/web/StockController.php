<?php
// src/Controller/web/StockController.php

require_once __DIR__ . '/../../Repository/StockBatchRepository.php';

class StockController
{
    private StockBatchRepository $repo;

    public function __construct()
    {
        $this->repo = new StockBatchRepository();
    }
    public function store()
    {
        ob_start();
        include __DIR__ . '/../../../templates/dashboard/add_batch.php';
        $content = ob_get_clean();

        include __DIR__ . '/../../../templates/layout/base.php';

    }



    public function financialReport()
    {
        if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'ADMIN') {
            header("Location: index.php?action=dashboard");
            exit;
        }

        $totalLoss = $this->repo->getFinancialLossTotal();

        ob_start();
        include __DIR__ . '/../../../templates/dashboard/report.php';
        $content = ob_get_clean();

        include __DIR__ . '/../../../templates/layout/base.php';
    }
}
