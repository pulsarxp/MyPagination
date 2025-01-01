<?php
$host="*****";
$username="*****";
$password="*****";
$db_name="*****";
$tbl_name="*****";

$conn = mysqli_connect("$host", "$username", "$password", "$db_name");

$datetime=date("y-m-d h:i:s");

$name = $_POST['name'];
$url = $_POST['url'];
$comment = $_POST['comment'];
$camtype = $_POST['cam_type'];
$category = $_POST['category'];

mysqli_set_charset($conn,"utf8");
$sql = "INSERT INTO $tbl_name (name, url, comment, cam_type, category) VALUES ('$name', '$url', '$comment', '$camtype', '$category')";
if (mysqli_query($conn, $sql)) {
 echo "New record created successfully";
} else {
 echo "Error: " . $sql . "<br>" . mysqli_error($conn);
}
mysqli_close($conn);


echo "<a href='writein.php'>Következő</a>";

?>
