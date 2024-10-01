<?php include "connect.php" ?>
<?php 
    $stmt = $pdo->prepare("SELECT * FROM member WHERE username = ?");
    $stmt->bindParam(1, $_GET["username"]);
    $stmt->execute();
    $row = $stmt->fetch();
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
        <div class="card">
            <div class="card-header">
                User detail
            </div>
            <div class="card-body">
                <div class="card-cover">
                    <img src='images/member_photo/<?=$row["image_path"]?>' />
                </div>
                <div class="card-detail">
                    <p>ชื่อสมาชิก : <?=$row["name"]?></p>
                    <p>ที่อยู่ : <?=$row["address"]?></p>
                    <p>email : <?=$row["email"]?></p>
                    <p>mobile : <?=$row["mobile"]?></p>
                </div>
            </div>

        </div>
    </main>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>