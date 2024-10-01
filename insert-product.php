<?php include "connect.php" ?>
<!doctype html>
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
                Insert Product
            </div>
            <form class="card-body" method="post" enctype="multipart/form-data">
                <label class="form-label" for="productname">Name</label>
                <input class="form-control mb-3" type="text" name="productname">

                <label class="form-label" for="productdetail">Detail</label>
                <input class="form-control mb-3" type="text" name="productdetail">

                <label class="form-label" for="price">Price</label>
                <input class="form-control mb-3" type="number" name="price">

                <label class="form-label" for="quantity">Quantity</label>
                <input class="form-control mb-3" type="number" name="quantity">

                <label class="form-label">Product image</label>
                <input class="form-control mb-3" type="file" accept="image/*" name="product">
                <input class="btn btn-primary" type="submit" value="Add product">
            </form>
        </div>

    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $addStatus = "";
        $uploadDirectory = "images/product_photo/";
        $productImage = $_FILES['product']['name'];

        $imageFileType = strtolower(pathinfo($productImage, PATHINFO_EXTENSION));
        $targetFile = $uploadDirectory . $_POST['productname'] . '.' . $imageFileType;
        $imageFileName = $_POST['productname'] . '.' . $imageFileType;

        // Validate image upload
        if (isset($_FILES['product']) && $_FILES['product']['error'] == 0) {
            $check = getimagesize($_FILES['product']['tmp_name']);
            if ($check === false) {
                $addStatus = "File is not an image.";
            } else {
                // Check file size (limit to 2MB)
                if ($_FILES['product']['size'] > 2000000) {
                    $addStatus = "Sorry, your file is too large.";
                }

                // Allow only JPG, JPEG, and PNG formats
                if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
                    $addStatus = "Sorry, only JPG, JPEG, and PNG files are allowed.";
                }

                // If no errors, move file to target directory with new name
                if (empty($addStatus)) {
                    if (move_uploaded_file($_FILES['product']['tmp_name'], $targetFile)) {
                        $addStatus = "The file " . htmlspecialchars($_POST['productname']) . " has been uploaded.";
                    } else {
                        $addStatus = "Sorry, there was an error uploading your file.";
                    }
                }
            }
        } else {
            if (!empty($_POST["productname"])) {
                $addStatus = "No file was uploaded.";
            } else {
                $addStatus = "Product name is required.";
            }
        }

        $stmt = $pdo->prepare("INSERT INTO product (pname, pdetail, price, quantity, image_path) VALUES (?, ?, ?, ?, ?)");
        $stmt->bindParam(1, $_POST["productname"]);
        $stmt->bindParam(2, $_POST["productdetail"]);
        $stmt->bindParam(3, $_POST["price"]);
        $stmt->bindParam(4, $_POST["quantity"]);
        $stmt->bindParam(5, $imageFileName);
        $stmt->execute();
    }
    ?>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>