<?php
// public/index.php
session_start();

require_once __DIR__ . '/../src/Controller/web/AuthController.php';
require_once __DIR__ . '/../src/Controller/web/DashboardController.php';
require_once __DIR__ . '/../src/Controller/web/StockController.php'; 
require_once __DIR__ . '/../src/Controller/api/ApiStockController.php';

$action = $_GET['action'] ?? 'dashboard';
$method = $_SERVER['REQUEST_METHOD'];

$authController = new AuthController();
$dashboardController = new DashboardController();
$webStockController = new StockController();     
$apiStockController = new ApiStockController();   


if (!isset($_SESSION['user_id']) && $action !== 'login') {
    header("Location: index.php?action=login");
    exit;
}


switch ($action) {
   
    case 'login':
        $authController->login();
        break;
    case 'logout':
        $authController->logout();
        break;
    case 'dashboard':
        $dashboardController->index();
        break;
    case 'add-batch':
        $webStockController->store();
        break;


    case 'api-lots':
        header('Content-Type: application/json');
        $apiStockController->apiGetLots();
        exit;

    case 'api-dispense':
        header('Content-Type: application/json');
        if ($method === 'POST') {
            $apiStockController->apiDispense();
        }
        exit;

    default:
        $dashboardController->index();
        break;
}