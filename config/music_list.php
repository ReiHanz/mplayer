<?php
include 'db.php';

$stmt = $pdo->query("SELECT * FROM music");
$results = $stmt->fetchAll(PDO::FETCH_ASSOC);
echo json_encode($results);
?>
