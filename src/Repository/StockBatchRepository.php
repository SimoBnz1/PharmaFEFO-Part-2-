<?php
// src/Repository/StockBatchRepository.php

require_once __DIR__ . '/../../config/database.php';

class StockBatchRepository {
    private PDO $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function find($id) {
        $stmt = $this->db->prepare("SELECT * FROM lot_stocks WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch();
    }

    public function updateQuantite($id, $newQty) {
        $stmt = $this->db->prepare("UPDATE lot_stocks SET quantite = ? WHERE id = ?");
        return $stmt->execute([$newQty, $id]);
    }

    public function getDashboardLots($filter = null) {
        $sql = "SELECT l.*, p.nom, p.reference FROM lot_stocks l 
                JOIN produits p ON l.produit_id = p.id";
        
        if ($filter === 'critical') {
            $sql .= " WHERE l.date_peremption <= DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
        } elseif ($filter === 'warning') {
            $sql .= " WHERE l.date_peremption <= DATE_ADD(CURDATE(), INTERVAL 90 DAY) AND l.date_peremption > DATE_ADD(CURDATE(), INTERVAL 30 DAY)";
        }
        
        $sql .= " ORDER BY l.date_peremption ASC";
        return $this->db->query($sql)->fetchAll();
    }

    public function getAllProducts() {
        return $this->db->query("SELECT * FROM produits ORDER BY nom ASC")->fetchAll();
    }

    public function saveInputBatch($productId, $lotNumber, $quantity, $expiryDateStr) {
        $stmt = $this->db->prepare("
            INSERT INTO lot_stocks (produit_id, numero_lot, quantite, date_peremption) 
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$productId, $lotNumber, $quantity, $expiryDateStr]);
    }

    public function getFefoBatchForProduct($productId) {
        $stmt = $this->db->prepare("
            SELECT * FROM lot_stocks 
            WHERE produit_id = ? AND quantite > 0 AND date_peremption >= CURDATE()
            ORDER BY date_peremption ASC LIMIT 1
        ");
        $stmt->execute([$productId]);
        return $stmt->fetch();
    }

    public function dispenseBatch($batchId, $qty) {
        $stmt = $this->db->prepare("UPDATE lot_stocks SET quantite = quantite - ? WHERE id = ? AND quantite >= ?");
        return $stmt->execute([$qty, $batchId, $qty]);
    }

    public function markBatchAsExpired($batchId) {
        $stmt = $this->db->prepare("UPDATE lot_stocks SET statut = 'EXPIRED', quantite = 0 WHERE id = ?");
        return $stmt->execute([$batchId]);
    }

    public function getFinancialLossTotal() {
        return $this->db->query("
            SELECT SUM(l.quantite * p.prix) as total 
            FROM lot_stocks l
            JOIN produits p ON l.produit_id = p.id
            WHERE l.date_peremption < CURDATE() OR l.statut = 'EXPIRED'
        ")->fetch()['total'] ?? 0.00;
    }
}