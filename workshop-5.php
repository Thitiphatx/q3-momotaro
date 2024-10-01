<?php include "connect.php" ?>
<?php 
    $stmt = $pdo->prepare("SELECT * FROM member WHERE username LIKE ?");
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
</head>

<body>
    <header>
        <?php include "components/navbar.php" ?>
    </header>
    <main>
        <form class="mb-3">
            <input class="form-control mb-3" name="keyword" placeholder="username"/>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <div class="gallery">
                    <?php
                        while ($row = $stmt->fetch()) {
                    ?>
                        <a href="workshop-5-2.php?username=<?=$row["username"]?>" class="card" style="min-width: fit-content;text-decoration: none;">
                            <div class="card-body">
                                <div class="card-cover">
                                    <img src='images/member_photo/<?=$row["image_path"]?>' />
                                </div>
                                <div class="card-detail">
                                    <p>ชื่อสมาชิก : <?=$row["name"]?></p>
                                    <p><?=$row["address"]?></p>
                                    <p><?=$row["email"]?></p>
                                </div>

                            </div>
                        </a>
                            
                    <?php
                        }
                    ?>
        </div>
    </main>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>