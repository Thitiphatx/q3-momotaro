<?php include "connect.php" ?>
<?php 
    session_start();
    $stmt = $pdo->prepare("SELECT * FROM product WHERE pname LIKE ?");
    $value = $_GET["keyword"] . '%';
    $stmt->bindParam(1, $value);
    $stmt->execute();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>CS SHOP</title>
    <script>

        function confirmDelete(pid) {
            var ans = confirm("ต้องการสินค้า "+pid);
            if (ans == true) {
                document.location = "php/deleteProduct.php?pid=" + pid;
            }
        }

    </script>
</head>

<body>
    <header>
        <?php include "components/navbar.php" ?>
    </header>
    <main>
        <form class="mb-3">
            <input class="form-control mb-3" name="keyword" placeholder="product name"/>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <div class="gallery">
                    <?php
                        while ($row = $stmt->fetch()) {
                    ?>
                    <div class="card" style="width: 18rem;">
                        <img src="images/product_photo/<?=$row["image_path"]?>" class="card-img-top" alt="<?=$row["pname"]?>">
                        <div class="card-body">
                            <h5 class="card-title"><?=$row["pname"]?></h5>
                            <p class="card-text"><?=$row["email"]?></p>
                            <a href="product-detail.php?pid=<?=$row["pid"]?>" class="btn btn-primary"><?=$row["price"]?> บาท</a>
                        </div>
                    </div>
                        <!-- <a href="product-detail.php?pid=<?=$row["pid"]?>" class="card" style="min-width: fit-content;">
                            <div class="card-body">
                                <div class="card-cover">
                                    <img src='images/product_photo/<?=$row["image_path"]?>' />
                                </div>
                                <div class="card-detail">
                                    <p>ชื่อสมาชิก : <?=$row["pname"]?></p>
                                    <p><?=$row["price"]?></p>
                                    <p><?=$row["email"]?></p>
                                    <?php
                                        if ($_SESSION["role"] == "admin" ) {
                                    ?>
                                        <button class="btn btn-danger" onclick='confirmDelete("<?=$row["pid"]?>")'>ลบ</button>
                                        <a class="btn btn-info" href="edit-product.php?pid=<?=$row["pid"]?>">แก้ไข</a>
                                    <?php
                                        }
                                    ?>

                                </div>

                            </div>
                        </a> -->
                            
                    <?php
                        }
                    ?>
        </div>
    </main>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>