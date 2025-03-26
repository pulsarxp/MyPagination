<?php
require_once 'config.php';
require_once 'Database.php';
require_once 'Panorama.php';

$db = new Database();
$panorama = new Panorama($db);

$categories = $panorama->getCategories();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $url = trim($_POST['url'] ?? '');
    $comment = trim($_POST['comment'] ?? '');
    $camType = $_POST['cam_type'] ?? '';
    $category = $_POST['category'] ?? '';

    $errors = [];

    if (empty($name)) {
        $errors[] = "A név megadása kötelező!";
    }

    if (empty($url)) {
        $errors[] = "Az URL megadása kötelező!";
    }

    if (empty($camType)) {
        $errors[] = "A kamera típusa kötelező!";
    }

    if (empty($category)) {
        $errors[] = "A kategória megadása kötelező!";
    }

    if (empty($errors)) {
        try {
            $panoramaData = [
                'name' => $name,
                'url' => $url,
                'comment' => $comment,
                'cam_type' => $camType,
                'category' => $category
            ];
            $panorama->addPanorama($panoramaData);
            header("Location: pan.php");
            exit;
        } catch (Exception $e) {
            $errors[] = "Hiba történt a mentés során: " . $e->getMessage();
        }
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Új panoráma hozzáadása</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/test.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <div class="container mt-5">
        <h1 class="mb-4">Új panoráma hozzáadása</h1>

        <?php if (!empty($errors)): ?>
            <div class="alert alert-danger">
                <ul class="mb-0">
                    <?php foreach ($errors as $error): ?>
                        <li><?= htmlspecialchars($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <form method="POST" action="">
            <div class="form-group">
                <label for="name">Név *</label>
                <input type="text" class="form-control" id="name" name="name" value="<?= isset($_POST['name']) ? htmlspecialchars($_POST['name']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="url">URL *</label>
                <input type="text" class="form-control" id="url" name="url" value="<?= isset($_POST['url']) ? htmlspecialchars($_POST['url']) : '' ?>" required>
            </div>

            <div class="form-group">
                <label for="comment">Megjegyzés</label>
                <textarea class="form-control" id="comment" name="comment" rows="3"><?= isset($_POST['comment']) ? htmlspecialchars($_POST['comment']) : '' ?></textarea>
            </div>

            <div class="form-group">
                <label for="cam_type">Kamera típusa *</label>
                <select class="form-control" id="cam_type" name="cam_type" required>
                    <option value="">Válasszon kamerát...</option>
                    <option value="g" <?= (isset($_POST['cam_type']) && $_POST['cam_type'] === 'g') ? 'selected' : '' ?>>Gear 360</option>
                    <option value="m" <?= (isset($_POST['cam_type']) && $_POST['cam_type'] === 'm') ? 'selected' : '' ?>>Mavic</option>
                    <option value="i" <?= (isset($_POST['cam_type']) && $_POST['cam_type'] === 'i') ? 'selected' : '' ?>>Insta360</option>
                </select>
            </div>

            <div class="form-group">
                <label for="category">Kategória *</label>
                <select class="form-control" id="category" name="category" required>
                    <option value="">Válasszon kategóriát...</option>
                    <?php foreach ($categories as $cat): ?>
                        <option value="<?= htmlspecialchars($cat['category']) ?>" 
                                <?= (isset($_POST['category']) && $_POST['category'] === $cat['category']) ? 'selected' : '' ?>>
                            <?= htmlspecialchars($cat['category']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Mentés</button>
            <a href="pan.php" class="btn btn-secondary">Vissza</a>
        </form>
    </div>
</body>
</html> 