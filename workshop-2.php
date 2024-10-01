<?php include "connect.php" ?>
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
            <div class="card-body">
                <?php
                $stmt = $pdo->prepare("SELECT * FROM member");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    echo "<p>ชื่อสมาชิก : " . $row["name"] . "</p>";
                    echo "<p>" . $row["address"] . "</p>";
                    echo "<p>" . $row["email"] . "</p>";
                    echo "<hr>";
                }
                ?>
            </div>
        </div>

    </main>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>

</html>