<?php
include 'parse\ParseWeb.php';


use models\Procedure;
use parse\ParseWeb;


error_reporting(E_ALL);
ini_set('display_errors', 1);

setlocale(LC_ALL, 'ru_RU');
date_default_timezone_set('Europe/Moscow');
header('Content-type: text/html; charset=utf-8');
//--------------------------------------------------------
$procArray = ParseWeb::Parse('https://etp.eltox.ru/registry/procedure?id=&procedure=&oos_id=&company=&inn=&type=1&price_from=&price_to=&published_from=&published_to=&offer_from=&offer_to=&status=');
$conn = new mysqli("localhost", "admin", "admin", "test");
if($conn->connect_error){
    die("Ошибка: " . $conn->connect_error);
}

foreach ($procArray as $procedure) {
    $sql = "INSERT INTO procedures (number, oocNumber, address, mail) VALUES ('$procedure->number',
     '$procedure->ooc_number', '$procedure->adress', '$procedure->mail')";
    if($conn->query($sql)){
        // echo "Данные успешно добавлены";
    } else{
        echo "Ошибка: " . $conn->error;
    }
    echo "-----------------------------------------------------------" . "<br>";
    echo "Номер процедуры: " . "$procedure->number<br>";
    echo "ООС номер процедуры: " . "$procedure->ooc_number<br>";
    echo "Ссылка на страницу процедуры: " . "$procedure->adress<br>";
    echo "Email: " . "$procedure->mail<br>";
}

?>

