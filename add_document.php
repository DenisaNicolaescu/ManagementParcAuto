<?php

include 'conexiune.php';

$car_id = $_POST['car_id'];
$doc_type = $_POST['doc_type'];
$provider = $_POST['provider'];
$expiry_date = $_POST['expiry_date'];

$query = "
INSERT INTO documents
(
    car_id,
    doc_type,
    provider,
    expiry_date
)
VALUES
(
    '$car_id',
    '$doc_type',
    '$provider',
    '$expiry_date'
)
";

mysqli_query($conn, $query);

header("Location: documents-m.php");
exit();

?>