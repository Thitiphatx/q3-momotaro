
<?php include "../connect.php";
    $stmt = $pdo->prepare("DELETE FROM member WHERE username=?");

    if (!empty($_GET)) {
        $value = $_GET["username"];
    }
    $stmt->bindParam(1, $value);
    if ($stmt->execute()) // เริ่มลบข้อมูล
        header("location: ../workshop-6.php");
?>
