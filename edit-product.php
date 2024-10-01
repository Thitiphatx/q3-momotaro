<?php 
    include "connect.php";
    session_start();
    if ($_SESSION["role"] !== "admin") {
        header("location: product.php");
    }
    $stmt = $pdo->prepare("SELECT * FROM product WHERE pid = ?");
    $stmt->bindParam(1, $_GET["pid"]);
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
            <img src="images/product_photo/<?=$row["image_path"]?>" alt="Product Image" style="max-width:100px;">
        </div>
        
        <form class="card-body" method="POST" enctype="multipart/form-data">
            <label for="pid">pid</label>
            <input class="form-control mb-3" type="text" name="pid" value="<?=$row["pid"]?>" disabled>

            <label for="pname">pname</label>
            <input class="form-control mb-3" type="text" name="pname" value="<?=$row["pname"]?>">

            <label for="pdetail">pdetail</label>
            <input class="form-control mb-3" type="text" name="pdetail" value="<?=$row["pdetail"]?>">

            <label for="price">price</label>
            <input class="form-control mb-3" type="text" name="price" value="<?=$row["price"]?>">

            <label for="quantity">quantity</label>
            <input class="form-control mb-3" type="text" name="quantity" value="<?=$row["quantity"]?>">

            <label>Product image</label>
            <input class="form-control mb-3" type="file" accept="image/*" name="product">
        
            <input class="btn btn-primary" type="submit" value="Update">
        </form>
    </div>

    <?php
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $uploadDirectory = "images/member_photo/";
        $productImage = $_FILES['product']['name'];
        $loginStatus = "";
        $imageFileName = $row['image_path']; // Default to current image path

        // Image upload handling
        if (!empty($productImage)) {
            $imageFileType = strtolower(pathinfo($productImage, PATHINFO_EXTENSION));
            $targetFile = $uploadDirectory . $_GET['username'] . '.' . $imageFileType;
            $imageFileName = $_GET['username'] . '.' . $imageFileType;

            // Validate image upload
            if ($_FILES['product']['error'] == 0 && getimagesize($_FILES['product']['tmp_name'])) {
                if ($_FILES['product']['size'] <= 2000000 && in_array($imageFileType, ['jpg', 'jpeg', 'png'])) {
                    if (move_uploaded_file($_FILES['product']['tmp_name'], $targetFile)) {
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
            $stmt = $pdo->prepare("UPDATE product SET pname = ?, pdetail = ?, price = ?, quantity = ?, image_path = ? WHERE pid = ?");
            $stmt->bindParam(1, $_POST["pname"]);
            $stmt->bindParam(2, $_POST["pdetail"]);
            $stmt->bindParam(3, $_POST["price"]);
            $stmt->bindParam(4, $_POST["quantity"]);
            $stmt->bindParam(5, $imageFileName);
            $stmt->bindParam(6, $_GET["pid"]);

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
