<?php
ob_start();
session_start();
require_once 'vendor/autoload.php';
require_once "app/controller/headerController.php";
require_once "app/controller/footerController.php";
require_once "app/controller/adminController.php";
require_once "app/model/settingModel.php";

$settingModel = new SettingModel();
$settings = $settingModel->getAll();

$appSettings = [];
foreach ($settings as $s) {
    $appSettings[$s['key_name']] = $s['value'];
}
$GLOBALS['appSettings'] = $appSettings;

$headerController = new HeaderController();
$footerController = new FooterController();
$adminController = new AdminController();
$routes = require "routers.php";
$page = $_GET['page'] ?? 'accueil';
 
if (!isset($routes[$page])) {
    die("Page not found");
}

$controllerName = $routes[$page]['controller'];
$actionName = $routes[$page]['action'];
$id = isset($_GET['id']) ? intval($_GET['id']) : null;


require_once "app/controller/{$controllerName}.php";
$controller = new $controllerName();


?>
<!DOCTYPE html>
<html lang="en" data-theme="<?= $appSettings['theme'] ?? 'light' ?>">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="public/css/global.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <title>Laboratoire Website</title>
    <style>
    :root {
        --primary: <?= $appSettings['primary-color']?>;
        --primary-light: <?= $appSettings['primary-light'] ?>;
        --primary-dark: <?= $appSettings['primary-dark']  ?>;
        --gray-light: <?= $appSettings['gray-light']  ?>;
        --gray: <?= $appSettings['gray'] ?>;
        --gray-dark: <?= $appSettings['gray-dark']  ?>;
        --white: <?= $appSettings['white']?>;
        --accent: <?= $appSettings['accent']  ?>;
        --success: <?= $appSettings['success']  ?>;
        --error: <?= $appSettings['error'] ?>;
    }
    [data-theme="dark"] {
    --primary: <?= $appSettings['white']?>;     
    --primary-light: <?= $appSettings['gray-dark']?>; 
    --primary-dark: <?= $appSettings['white']?>;
    --gray-light: <?= $appSettings['gray-dark']?>;
    --gray: <?= $appSettings['gray']?>;
    --gray-dark: <?= $appSettings['gray-light']?>;
    --white: <?= $appSettings['primary-dark']?>;
    --accent: <?= $appSettings['accent']?>;
    --success: <?= $appSettings['success']?>;
    --error: <?= $appSettings['error']?>;
}
    </style>
</head>

<body class="bg-[var(--gray-light)]">
      <?php 
          echo "<header>";
            $headerController->showHeader();
          echo "</header>";
          echo "<main class='min-h-screen flex justify-center'>";
            if ($id !== null) {
                $controller->$actionName($id);
            } else {
                $controller->$actionName();
            }
          echo "</main>";
          echo "<footer>";
            $footerController->showFooter();
          echo "</footer>";
      ?>
<script src="/Site_laboratoire/public/js/app.js"></script>
</body>
</html>

<?php
ob_end_flush();?>