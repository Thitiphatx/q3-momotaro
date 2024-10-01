<?php include "connect.php" ?>
<?php
    session_start();
    if (!empty($_SESSION["username"])) {
        header("location: index.php");
    }

    // execute login
    $stmt = $pdo->prepare("SELECT * FROM member WHERE username = ? AND password = ?");
    $stmt->bindParam(1, $_POST["username"]);
    $stmt->bindParam(2, $_POST["password"]);
    $stmt->execute();
    $row = $stmt->fetch();

    if (!empty($row)) {
        $_SESSION["name"] = $row["name"];
        $_SESSION["username"] = $row["username"];
        $_SESSION["role"] = $row["role"];
    
        header("location: index.php");
    } else {
        $loginStatus = "ไม่สำเร็จ ชื่อหรือรหัสผ่านไม่ถูกต้อง";
    }
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
    <div class="card mx-auto my-3" style="width:50%;">
        <div class="card-header">
            Login
        </div>
        <form class="card-body" method="POST">
            <label class="form-label" for="username">Username</label>
            <input class="form-control mb-3" type="text" name="username">
            
            <label class="form-label" for="password">Password</label>
            <input class="form-control mb-3" type="password" name="password">
            
            <input class="btn btn-primary" type="submit" value="Login">
        </form>
    </div>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>