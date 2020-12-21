<?php

declare(strict_types=1);

require_once '../vendor/autoload.php';

$app = new App\App();

$conn = mysqli_connect("localhost", "zadanie", "zadanie", "zadanie");

$id = $_GET['id'];

$sql = "DELETE FROM `articles` WHERE `id` = $id";
$data = mysqli_query($conn, $sql);

if ($data) {
    $app->session->addFlash('success', 'Usunięto artykuł');
    $app->router->redirect('index.php');
} else {
    echo 'Coś poszło nie tak ';
}
?>
