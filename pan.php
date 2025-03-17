<?php
require_once 'config.php';
require_once 'Database.php';
require_once 'Panorama.php';

$db = new Database();
$panorama = new Panorama($db);

$page = isset($_GET['pageno']) ? (int)$_GET['pageno'] : 1;
$category = isset($_GET['category']) ? $_GET['category'] : null;

$categories = $panorama->getCategories();
$panoramas = $panorama->getPanoramas($page, $category);
$totalPages = $panorama->getTotalPages($category);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Panoráma képek</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/test.css">
    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
</head>
<body>
    <table width="800" border="0" align="center" cellpadding="20" cellspacing="20">
        <tr align="center">
            <td align="center" style="font-size: 40px;">Panoráma képek</td>
        </tr>
    </table>

    <div style="text-align: center; margin-bottom: 20px;">
        <a href="add_panorama.php" class="btn btn-primary">Új panoráma hozzáadása</a>
    </div>

    <form method="GET" action="" style="text-align: center; margin-bottom: 20px;">
        <label for="typeFilter">Szűrés típus szerint:</label><br>
        <a href="?category=" class="btn btn-secondary" style="margin: 5px;">Összes</a>
        <?php foreach ($categories as $cat): ?>
            <?php $activeClass = ($category === $cat['category']) ? 'btn-primary' : 'btn-secondary'; ?>
            <a href="?category=<?= htmlspecialchars($cat['category']) ?>" 
               class="btn <?= $activeClass ?>" 
               style="margin: 5px;"><?= htmlspecialchars($cat['category']) ?></a>
        <?php endforeach; ?>
    </form>

    <?php foreach ($panoramas as $row): ?>
        <div class="box effect1">
            <table width="800" border="0">
                <tr>
                    <th colspan="2" width="90%">
                        <a href="http://<?= htmlspecialchars($row['url']) ?>" target="_blank" style="font-size: 20px;">
                            <?= htmlspecialchars($row['name']) ?>
                        </a>
                    </th>
                    <th rowspan="2">
                        <img src="<?= $panorama->getCameraImage($row['cam_type']) ?>" alt="Cam" height="75" width="75">
                    </th>
                </tr>
                <tr>
                    <td colspan="2"><?= htmlspecialchars($row['comment']) ?></td>
                </tr>
            </table>
        </div>
    <?php endforeach; ?>

    <table width="800" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td width="80%">
                <ul class="pagination">
                    <li><a href="?pageno=1<?= $category ? '&category=' . urlencode($category) : '' ?>">Első</a></li>
                    <li class="<?= $page <= 1 ? 'disabled' : '' ?>">
                        <a href="<?= $page <= 1 ? '#' : '?pageno=' . ($page - 1) . ($category ? '&category=' . urlencode($category) : '') ?>">Előző</a>
                    </li>
                    <li class="<?= $page >= $totalPages ? 'disabled' : '' ?>">
                        <a href="<?= $page >= $totalPages ? '#' : '?pageno=' . ($page + 1) . ($category ? '&category=' . urlencode($category) : '') ?>">Következő</a>
                    </li>
                    <li><a href="?pageno=<?= $totalPages ?><?= $category ? '&category=' . urlencode($category) : '' ?>">Utolsó</a></li>
                </ul>
            </td>
            <td align="right"><?= $page ?>. oldal a(z) <?= $totalPages ?> oldalból</td>
        </tr>
    </table>
</body>
</html>
