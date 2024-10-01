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
    <table class="table">
        <thead>
            <tr>
                <th>pid</th>
                <th>pname</th>
                <th>pdetail</th>
                <th>price</th>
            </tr>
        </thead>
        <tbody>
            <?php 
                $stmt = $pdo->prepare("SELECT * FROM product");
                $stmt->execute();
                while ($row = $stmt->fetch()) {
                    echo "<tr>";
                    echo "<td>" . $row["pid"] . "</td>";
                    echo "<td>" . $row["pname"] . "</td>";
                    echo "<td>" . $row["pdetail"] . "</td>";
                    echo "<td>" . $row["price"] . "</td>";
                    echo "</tr>";
                }
            ?>
        </tbody>

    </table>
    </main>


    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>