
<?php include "../connect.php";
    $stmt = $pdo->prepare("DELETE FROM product WHERE pid=?");

    if (!empty($_GET)) {
        $value = $_GET["pid"];
    }
    $stmt->bindParam(1, $value);
    if ($stmt->execute()) // เริ่มลบข้อมูล
        header("location: ../product.php");
?>
