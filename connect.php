<?php
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=sec1_11;charset=utf8", "Wstd11", "pQDtm1bb");
    } catch (PDOException $e) {
        echo "เกิดข้อผิดพลาด : ".$e->getMessage();
    }
?>