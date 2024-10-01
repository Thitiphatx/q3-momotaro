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
    <script>

        function confirmDelete(uid) {
            var ans = confirm("ต้องการลบผู้ใช้ "+uid);
            if (ans == true) {
                document.location = "php/deleteUser.php?username=" + uid;
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
            <input class="form-control mb-3" name="keyword" placeholder="username"/>
            <input class="btn btn-primary" type="submit" value="search" />
        </form>
        <div class="gallery">
                    <?php
                        while ($row = $stmt->fetch()) {
                    ?>
                        <div class="card" style="min-width: fit-content;">
                            <div class="card-body">
                                <div class="card-cover">
                                    <img src='images/member_photo/<?=$row["image_path"]?>' />
                                </div>
                                <div class="card-detail">
                                    <p>ชื่อสมาชิก : <?=$row["name"]?></p>
                                    <p><?=$row["address"]?></p>
                                    <p><?=$row["email"]?></p>
                                    <button class="btn btn-danger" onclick='confirmDelete("<?=$row["username"]?>")'>ลบ</button>
                                    <a class="btn btn-info" href="workshop-9-2.php?username=<?=$row["username"]?>">แก้ไข</a>
                                </div>

                            </div>
                        </div>
                            
                    <?php
                        }
                    ?>
        </div>
    </main>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>