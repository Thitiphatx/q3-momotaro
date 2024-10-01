<?php include "connect.php";
    session_start();
    $stmt = $pdo->prepare("SELECT * FROM product WHERE pid = ?");
    $stmt->bindParam(1, $_GET["pid"]);
    $stmt->execute();
    $row = $stmt->fetch();

    $stmt2 = $pdo->prepare("
        SELECT username, SUM(item.quantity) as total_quantity 
        FROM item 
        JOIN orders ON item.ord_id = orders.ord_id 
        WHERE item.pid = ?
        GROUP BY username
    ");
    $stmt2->bindParam(1, $_GET["pid"]);
    $stmt2->execute();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>CS SHOP</title>
</head>

<body>
    <header>
        <?php include "components/navbar.php" ?>
    </header>
    <main>
        <div style="display: flex;flex-flow:row wrap;gap: 10px;">
            <div class="card" style="width: 18rem;">
                <img src="images/product_photo/<?= $row["image_path"] ?>" class="card-img-top" alt="<?= $row["pname"] ?>">
                <div class="card-body">
                    <h5 class="card-title"><?= $row["pname"] ?></h5>
                    <ul>
                        <li><p class="card-text">รายละเอียดสินค้า: <?= $row["pdetail"] ?></p></li>
                        <li><p class="card-text">ราคา: <?= $row["price"] ?> บาท</p></li>
                    </ul>
                    <form class="input-group" method="post" action="cart.php?action=add&pid=<?= $row["pid"] ?>&pname=<?= $row["pname"] ?>&price=<?= $row["price"] ?>">
                        <input class="form-control" type="number" name="qty" value="1" min="1" max="9">
                        <input class="btn btn-primary" type="submit" value="ซื้อ">
                    </form>
                </div>
            </div>
            <div class="card" style="width: 18rem;">
                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>ชื่อผู้สั่ง</th>
                                <th>จำนวน</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php while ($row2 = $stmt2->fetch()) { ?>
                                <tr>
                                    <td><?= $row2["username"] ?></td>
                                    <td><?= $row2["total_quantity"] ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                    
                    
                </div>
            </div>
        </div>
    </main>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>