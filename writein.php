<?php
require_once 'config.php';
require_once 'Database.php';
require_once 'Panorama.php';

$db = new Database();
$panorama = new Panorama($db);

$success = isset($_GET['success']) ? $_GET['success'] : false;
$errors = isset($_GET['errors']) ? explode(',', $_GET['errors']) : [];
?>
<!DOCTYPE html>
<html>
<head>
    <title>Új panoráma hozzáadása</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/test.css">
</head>
<body>
    <table width="600" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td><strong>Új panoráma hozzáadása</strong></td>
        </tr>
    </table>

    <?php if ($success): ?>
        <div class="alert alert-success" role="alert">
            A panoráma sikeresen hozzáadva!
        </div>
    <?php endif; ?>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger" role="alert">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?= htmlspecialchars($error) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <table width="600" border="0" align="center" cellpadding="0" cellspacing="1" bgcolor="#CCCCCC">
        <tr>
            <form id="form" name="form" method="post" action="add.php">
                <td>
                    <table width="800" border="0" cellpadding="3" cellspacing="1" bgcolor="#FFFFFF">
                        <tr>
                            <td></td>
                            <td></td>
                            <td>Név</td>
                            <td>URL</td>
                            <td>Megjegyzés:</td>
                            <td>Kamera típus</td>
                            <td>Kategória</td>
                        </tr>
                        <tr>
                            <td valign="top">Napi</td>
                            <td valign="top">:</td>
                            <td><textarea name="name" cols="20" rows="1" id="name" required></textarea></td>
                            <td><textarea name="url" cols="20" rows="1" id="url" required></textarea></td>
                            <td><textarea name="comment" cols="30" rows="1" id="comment"></textarea></td>
                            <td>
                                <select name="cam_type" id="cam_type" required>
                                    <option value="">Válassz...</option>
                                    <option value="g">Gear 360</option>
                                    <option value="m">Mavic</option>
                                    <option value="i">Insta360</option>
                                    <option value="n">Nikon</option>
                                </select>
                            </td>
                            <td><textarea name="category" cols="5" rows="1" id="category"></textarea></td>
                        </tr>
                        <tr>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                            <td>
                                <input type="submit" name="Küld" value="Küld" class="btn btn-primary" />
                                <input type="reset" name="Submit2" value="Reset" class="btn btn-secondary" />
                            </td>
                        </tr>
                    </table>
                </td>
            </form>
        </tr>
    </table>
    <table width="400" border="0" align="center" cellpadding="3" cellspacing="0">
        <tr>
            <td><strong><a href="pan.php">Megtekintés</a></strong></td>
        </tr>
    </table>
</body>
</html>
