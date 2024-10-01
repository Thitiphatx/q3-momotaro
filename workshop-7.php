<?php 
include "connect.php";
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
            Insert User
        </div>
        <form class="card-body" method="POST" enctype="multipart/form-data">
            <label for="username">Username</label>
            <input class="form-control mb-3" type="text" name="username" required>

            <label for="password">Password</label>
            <input class="form-control mb-3" type="password" name="password" required>

            <label for="name">Name</label>
            <input class="form-control mb-3" type="text" name="name" required>

            <label for="address">Address</label>
            <input class="form-control mb-3" type="text" name="address" required>

            <label for="mobile">Mobile</label>
            <input class="form-control mb-3" type="text" name="mobile" required>

            <label for="email">Email</label>
            <input class="form-control mb-3" type="email" name="email" required>

            <label>Profile image</label>
            <input class="form-control mb-3" type="file" accept="image/*" name="profile">
        
            <input class="btn btn-primary" type="submit" value="Add">
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uploadDirectory = "images/member_photo/";
        $profileImage = $_FILES['profile']['name'];
        $loginStatus = "";

        // Get file extension
        $imageFileType = strtolower(pathinfo($profileImage, PATHINFO_EXTENSION));
        $targetFile = $uploadDirectory . $_POST['username'] . '.' . $imageFileType;
        $imageFileName = $_POST['username'] . '.' . $imageFileType;

        // Validate image upload
        if (isset($_FILES['profile']) && $_FILES['profile']['error'] == 0) {
            $check = getimagesize($_FILES['profile']['tmp_name']);
            if ($check !== false) {
                // Check file size (limit: 2MB)
                if ($_FILES['profile']['size'] <= 2000000) {
                    // Allow only JPG, JPEG, and PNG
                    if (in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                        // Attempt to upload file
                        if (move_uploaded_file($_FILES['profile']['tmp_name'], $targetFile)) {
                            $loginStatus = "ภาพ " . $_POST['username'] . " ถูกอัพโหลดแล้ว.";
                        } else {
                            $loginStatus = "Error: ไม่สามารถอัพโหลดภาพได้.";
                        }
                    } else {
                        $loginStatus = "Error: รองรับ JPG, JPEG, PNG เท่านั้น.";
                    }
                } else {
                    $loginStatus = "Error: ไฟล์ขนาดใหญ่เกินไป.";
                }
            } else {
                $loginStatus = "Error: ภาพไม่สมบูรณ์.";
            }
        } else {
            $loginStatus = "ไม่มีภาพ.";
        }

        // Insert data into the database
        try {
            $stmt = $pdo->prepare("INSERT INTO member (username, password, name, address, mobile, email, image_path) VALUES (?, ?, ?, ?, ?, ?, ?)");
            $stmt->bindParam(1, $_POST["username"]);
            $stmt->bindParam(2, $_POST["password"]); // Store hashed password
            $stmt->bindParam(3, $_POST["name"]);
            $stmt->bindParam(4, $_POST["address"]);
            $stmt->bindParam(5, $_POST["mobile"]);
            $stmt->bindParam(6, $_POST["email"]);
            $stmt->bindParam(7, $imageFileName);

            if ($stmt->execute()) {
                echo "<div class='alert alert-success'>เพิ่มผู้ใช้สำเร็จ.</div>";
            } else {
                echo "<div class='alert alert-danger'>Error: ไม่สามารถ Insert ข้อมูลได้.</div>";
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
