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
$conn = mysqli_connect("*****", "*****", "*****", "*****");
mysqli_set_charset($conn, "utf8");

if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    die();
}

$typeOptions = "";
$typeQuery = "SELECT DISTINCT types FROM 360menu_com WHERE types IS NOT NULL";
$typeResult = mysqli_query($conn, $typeQuery);
if ($typeResult) {
    while ($typeRow = mysqli_fetch_assoc($typeResult)) {
        $selected = (isset($_GET['types']) && $_GET['types'] == $typeRow['types']) ? 'selected' : '';
        $typeOptions .= "<option value='{$typeRow['types']}' $selected>{$typeRow['types']}</option>";
    }
}
?>

<form method="GET" action="" style="text-align: center; margin-bottom: 20px;">
    <label for="typeFilter">Szűrés típus szerint:</label>
    <select id="typeFilter" name="types">
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
$no_of_records_per_page = 8;
$offset = ($pageno - 1) * $no_of_records_per_page;

$typeFilter = "";
if (isset($_GET['types']) && $_GET['types'] != "") {
    $typeFilter = "WHERE types = '" . mysqli_real_escape_string($conn, $_GET['types']) . "'";
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
    $comment = $row["megj"];
    $icam = $row["cam"];
    $types = $row["types"];
    if ($icam == "g") {
        $kep = "gear.png";
    } elseif ($icam == "m") {
        $kep = "mavic.png";
    } elseif ($icam == "i") {
        $kep = "insta360.png";
    } else {
        $kep = "nikon.png";
    }
    echo '<table width="800" border="0"><tr><th colspan="2"  width="90%"><a href="http://' . $url . '" target="_blank" style="font-size: 20px;">' . $name . '</a></th><th rowspan="2"><img src="' . $kep . '" alt="Cam" height="75" width="75"></th></tr><tr><td colspan="2">' . $comment . '</td></tr></table>';
    echo '</div>';
}
mysqli_close($conn);

?>
<table width="800" border="0" align="center" cellpadding="3" cellspacing="0">
<tr>
<td width="80%">
    <ul class="pagination">
        <li><a href="?pageno=1<?php if(isset($_GET['types'])) echo '&types=' . $_GET['types']; ?>">Első</a></li>
        <li class="<?php if($pageno <= 1){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno <= 1){ echo '#'; } else { echo "?pageno=" . ($pageno - 1) . (isset($_GET['types']) ? '&types=' . $_GET['types'] : ''); } ?>">Előző</a>
        </li>
        <li class="<?php if($pageno >= $total_pages){ echo 'disabled'; } ?>">
            <a href="<?php if($pageno >= $total_pages){ echo '#'; } else { echo "?pageno=" . ($pageno + 1) . (isset($_GET['types']) ? '&types=' . $_GET['types'] : ''); } ?>">Következő</a>
        </li>
        <li><a href="?pageno=<?php echo $total_pages; ?><?php if(isset($_GET['types'])) echo '&types=' . $_GET['types']; ?>">Utolsó</a></li>
    </ul>
</td>
<?php
echo '<td align="right">' . $pageno . '. oldal a(z) ' . $total_pages . ' oldalból</td>';
?>
</tr>
</table>

</body>
</html>