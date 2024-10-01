<?php 
    include "connect.php";
    session_start();
    if ($_SESSION["username"] !== $_GET["username"] && $_SESSION["role"] !== "admin") {
        header("location: member.php");
    }
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
        <?php include "components/navbar.php"; ?>
    </header>
    <div class="card mx-auto my-3" style="width:50%;">
        <div class="card-header">
            Edit User
        </div>
        <div style="margin: 0 auto;">
            <img src="images/member_photo/<?=$row["image_path"]?>" alt="Profile Image" style="max-width:100px;">
        </div>
        
        <form class="card-body" method="POST" enctype="multipart/form-data">
            <label for="username">Username</label>
            <input class="form-control mb-3" type="text" name="username" value="<?=$row["username"]?>" disabled>

            <label for="password">Password</label>
            <input class="form-control mb-3" type="password" name="password" value="<?=$row["password"]?>" required>

            <label for="name">Name</label>
            <input class="form-control mb-3" type="text" name="name" value="<?=$row["name"]?>" required>

            <label for="address">Address</label>
            <input class="form-control mb-3" type="text" name="address" value="<?=$row["address"]?>" required>

            <label for="mobile">Mobile</label>
            <input class="form-control mb-3" type="text" name="mobile" value="<?=$row["mobile"]?>" required>

            <label for="email">Email</label>
            <input class="form-control mb-3" type="email" name="email" value="<?=$row["email"]?>" required>

            <label>Profile image</label>
            <input class="form-control mb-3" type="file" accept="image/*" name="profile">
        
            <input class="btn btn-primary" type="submit" value="Update">
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uploadDirectory = "images/member_photo/";
        $profileImage = $_FILES['profile']['name'];
        $loginStatus = "";
        $imageFileName = $row['image_path']; // Default to current image path

        // Image upload handling
        if (!empty($profileImage)) {
            $imageFileType = strtolower(pathinfo($profileImage, PATHINFO_EXTENSION));
            $targetFile = $uploadDirectory . $_GET['username'] . '.' . $imageFileType;
            $imageFileName = $_GET['username'] . '.' . $imageFileType;

            // Validate image upload
            if ($_FILES['profile']['error'] == 0 && getimagesize($_FILES['profile']['tmp_name'])) {
                if ($_FILES['profile']['size'] <= 2000000 && in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                    if (move_uploaded_file($_FILES['profile']['tmp_name'], $targetFile)) {
                        $loginStatus = "The file " . $_GET['username'] . " has been uploaded.";
                    } else {
                        $loginStatus = "Error: Unable to upload your file.";
                    }
                } else {
                    $loginStatus = "Error: Only JPG, JPEG, and PNG files under 2MB are allowed.";
                }
            } else {
                $loginStatus = "Error: Invalid image file.";
            }
        }

        // Update data in the database
        try {
            $stmt = $pdo->prepare("UPDATE member SET password = ?, name = ?, address = ?, mobile = ?, email = ?, image_path = ? WHERE username = ?");
            $stmt->bindParam(1, $_POST["password"]);
            $stmt->bindParam(2, $_POST["name"]);
            $stmt->bindParam(3, $_POST["address"]);
            $stmt->bindParam(4, $_POST["mobile"]);
            $stmt->bindParam(5, $_POST["email"]);
            $stmt->bindParam(6, $imageFileName);
            $stmt->bindParam(7, $_GET["username"]);

            if ($stmt->execute()) {
                exit(); // Stop script execution after redirect
            } else {
                echo "<div class='alert alert-danger'>Error: Unable to update user data.</div>";
            }
        } catch (PDOException $e) {
            echo "<div class='alert alert-danger'>Database error: " . $e->getMessage() . "</div>";
        }

        echo "<div class='alert alert-info'>$loginStatus</div>";
    }
    ?>

    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
