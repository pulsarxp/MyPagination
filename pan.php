<html>
<head>
    <title>Panoráma képek</title>
    <link rel="stylesheet" href="bootstrap.min.css">
    <link rel="stylesheet" href="test.css">
    <script src="jquery-3.3.1.min.js"></script>
    <script src="bootstrap.min.js"></script>
</head>
<body>

<table width="800" border="0" align="center" cellpadding="20" cellspacing="20">
<tr align="center"><td align="center" style="font-size: 40px;">Panoráma képek</td></tr>
</table>

<?php

require 'db_connect.php';

$typeOptions = "";
$typeQuery = "SELECT DISTINCT category FROM 360menu_com WHERE category IS NOT NULL";
$typeResult = mysqli_query($conn, $typeQuery);
if ($typeResult) {
    while ($typeRow = mysqli_fetch_assoc($typeResult)) {
        $selected = (isset($_GET['category']) && $_GET['category'] == $typeRow['category']) ? 'selected' : '';
        $typeOptions .= "<option value='{$typeRow['category']}' $selected>{$typeRow['category']}</option>";
    }
}
?>

<form method="GET" action="" style="text-align: center; margin-bottom: 20px;">
    <label for="typeFilter">Szűrés típus szerint:</label>
    <select id="typeFilter" name="category">
        <option value="">Összes</option>
        <?php echo $typeOptions; ?>
    </select>
    <button type="submit" class="btn btn-primary">Szűrés</button>
</form>

<?php
if (isset($_GET['pageno'])) {
    $pageno = $_GET['pageno'];
} else {
    $pageno = 1;
}
$no_of_records_per_page = 10;
$offset = ($pageno - 1) * $no_of_records_per_page;

$typeFilter = "";
if (isset($_GET['category']) && $_GET['category'] != "") {
    $typeFilter = "WHERE category = '" . mysqli_real_escape_string($conn, $_GET['category']) . "'";
}

$total_pages_sql = "SELECT COUNT(*) FROM 360menu_com $typeFilter";
$result = mysqli_query($conn, $total_pages_sql);
$total_rows = mysqli_fetch_array($result)[0];
$total_pages = ceil($total_rows / $no_of_records_per_page);

$sql = "SELECT * FROM 360menu_com $typeFilter ORDER BY ID DESC LIMIT $offset, $no_of_records_per_page";
$res_data = mysqli_query($conn, $sql);
while ($row = mysqli_fetch_array($res_data)) {
    echo '<div class="box effect1">';
    $name = $row["name"];
    $url = $row["url"];
    $comment = $row["comment"];
    $camtype = $row["cam_type"];
    $category = $row["category"];
    if ($camtype == "g") {
        $image = "gear.png";
    } elseif ($camtype == "m") {
        $image = "mavic.png";
    } elseif ($camtype == "i") {
        $image = "insta360.png";
    } else {
        $image = "nikon.png";
    }
    echo '<table width="800" border="0"><tr><th colspan="2"  width="90%"><a href="http://' . $url . '" target="_blank" style="font-size: 20px;">' . $name . '</a></th><th rowspan="2"><img src="' . $image . '" alt="Cam" height="75" width="75"></th></tr><tr><td colspan="2">' . $comment . '</td></tr></table>';
    echo '</div>';
}
mysqli_close($conn);

?>
<table width="800" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>
<td width="80%">
    <ul class="pagination">
        <li><a href="?pageno=1<?php if(isset($_GET['category'])) echo '&category=' . $_GET['category']; ?>">Első</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=" . ($pageno - 1) . (isset($_GET['category']) ? '&category=' . $_GET['category'] : ''); } ?>">Előző</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=" . ($pageno + 1) . (isset($_GET['category']) ? '&category=' . $_GET['category'] : ''); } ?>">Következő</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?><?php if(isset($_GET['category'])) echo '&category=' . $_GET['category']; ?>">Utolsó</a></li>
    </ul>
</td>
<?php
echo '<td align="right">' . $pageno . '. oldal a(z) ' . $total_pages . ' oldalból</td>';
?>
</tr>
</table>

</body>
</html>
