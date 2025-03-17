<?php
require_once 'config.php';
require_once 'Database.php';
require_once 'Panorama.php';

// Validáció
$errors = [];
$data = [
    'name' => $_POST['name'] ?? '',
    'url' => $_POST['url'] ?? '',
    'comment' => $_POST['comment'] ?? '',
    'cam_type' => $_POST['cam_type'] ?? '',
    'category' => $_POST['category'] ?? ''
];

// Validáció
if (empty($data['name'])) {
    $errors[] = "A név megadása kötelező!";
}

if (empty($data['url'])) {
    $errors[] = "Az URL megadása kötelező!";
} elseif (!filter_var($data['url'], FILTER_VALIDATE_URL)) {
    $errors[] = "Érvénytelen URL formátum!";
}

if (empty($data['cam_type'])) {
    $errors[] = "A kamera típus megadása kötelező!";
}

if (empty($errors)) {
    $db = new Database();
    $panorama = new Panorama($db);
    
    try {
        $panorama->addPanorama($data);
        header("Location: writein.php?success=1");
        exit;
    } catch (Exception $e) {
        $errors[] = "Hiba történt a mentés során: " . $e->getMessage();
    }
}

// Ha hiba történt, visszairányítjuk a formhoz
if (!empty($errors)) {
    header("Location: writein.php?errors=" . urlencode(implode(", ", $errors)));
    exit;
}
