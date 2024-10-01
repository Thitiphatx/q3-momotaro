<?php 
    include "../connect.php";
    session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light mb-3">
    <div class="container-fluid">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTogglerDemo01" aria-controls="navbarTogglerDemo01" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarTogglerDemo01">
            <a class="navbar-brand" href="#">CS SHOP</a>
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <li class="nav-item">
                    <a class="nav-link" href="member.php">Member</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="product.php">Product</a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Workshop
                    </a>
                    <ol class="dropdown-menu" style="list-style: decimal; margin-left: 10px;" aria-labelledby="navbarDropdown">
                        <li><a class="dropdown-item" href="workshop-1.php">All product</a></li>
                        <li><a class="dropdown-item" href="workshop-2.php">All member</a></li>
                        <li><a class="dropdown-item" href="workshop-3.php">All member with image</a></li>
                        <li><a class="dropdown-item" href="workshop-4.php">Search member</a></li>
                        <li><a class="dropdown-item" href="workshop-5.php">Member detail</a></li>
                        <li><a class="dropdown-item" href="workshop-6.php">Delete</a></li>
                        <li><a class="dropdown-item" href="workshop-7.php">Insert member</a></li>
                        <li><a class="dropdown-item" href="workshop-8.php">Insert member with result</a></li>
                        <li><a class="dropdown-item" href="workshop-9.php">Edit member</a></li>
                    </ol>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="cart.php">Cart</a>
                </li>
            </ul>
            <?php 
                if (empty($_SESSION["username"])) {
                    echo "<a class='btn btn-primary' href='login.php'>login</a>";
                } else {
                    echo $_SESSION["username"];
                    echo "<a href='php/logout.php'>logout</a>";
                }

            ?>
            
        </div>
    </div>
</nav>