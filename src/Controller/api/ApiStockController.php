<?php
// src/Controller/api/ApiStockController.php

require_once __DIR__ . '/../../Repository/StockBatchRepository.php';
require_once __DIR__ . '/../../Repository/MouvementRepository.php';
require_once __DIR__ . '/../../Repository/ProductRepository.php';

class ApiStockController
{
    private StockBatchRepository $repo;
    private MouvementRepository $mouvementRepo;
    private ProductRepository $productRepo;

    public function __construct()
    {
        $this->repo = new StockBatchRepository();
        $this->mouvementRepo = new MouvementRepository();
        $this->productRepo = new ProductRepository();
    }

    public function apiGetLots()
    {
        $filter = $_GET['filter'] ?? null;
        $lots = $this->repo->getDashboardLots($filter);

        $processed = [];
        $today = new DateTime();

        foreach ($lots as $lot) {
            $dlu = new DateTime($lot['date_peremption']);
            $diff = $today->diff($dlu);
            $jours = $diff->days * ($diff->invert ? -1 : 1);

            if ($lot['quantite'] <= 0) {
                $lot['color_classes'] = 'crit-rouge';
                $lot['badge_text'] = 'Épuisé';
            } elseif ($jours < 0) {
                $lot['color_classes'] = 'crit-rouge';
                $lot['badge_text'] = 'EXPIRED';
            } elseif ($jours < 30) {
                $lot['color_classes'] = 'crit-rouge';
                $lot['badge_text'] = 'Rouge (< 30 j)';
            } elseif ($jours < 90) {
                $lot['color_classes'] = 'crit-orange';
                $lot['badge_text'] = 'Orange (< 90 j)';
            } else {
                $lot['color_classes'] = 'crit-vert';
                $lot['badge_text'] = 'Vert (> 6 mois)';
            }
            $processed[] = $lot;
        }

        echo json_encode($processed);
        exit;
    }

    public function apiDispense()
    {
        $input = json_decode(file_get_contents('php://input'), true);
        $id = $input['id'] ?? null;

        if (!$id) {
            http_response_code(400);
            echo json_encode(['success' => false, 'message' => 'ID manquant']);
            exit;
        }

        $lot = $this->repo->find($id);
        if ($lot && $lot['quantite'] > 0) {
            $newQty = $lot['quantite'] - 1;
            $this->repo->updateQuantite($id, $newQty);
            $this->mouvementRepo->logMouvement($id, 'SORTIE', 1);
            echo json_encode(['success' => true, 'new_qty' => $newQty]);
        } else {
            echo json_encode(['success' => false, 'message' => 'Stock épuisé ou introuvable']);
        }
        exit;
    }



    public function storeBatch()
    {
        header("Content-Type: application/json");
        $data = json_decode(file_get_contents("php://input"), true);

        $repo = new StockBatchRepository(Database::getConnection());
        $result = $repo->saveInputBatch($data['produit_id'], $data['numero_lot'], $data['quantite'], $data['date_peremption']);
         echo json_encode([
            "success" => $result
        ]);
        exit;
    }

    
}
