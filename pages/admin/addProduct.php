<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../auth/auth.php");
    exit();
}

if (isset($_POST['submit'])) {
    $albumName = mysqli_real_escape_string($conn, $_POST['albumName']);
    $artistName = mysqli_real_escape_string($conn, $_POST['artistName']);
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $albumDesc = mysqli_real_escape_string($conn, $_POST['albumDesc']);
    $category_id = mysqli_real_escape_string($conn, $_POST['category_id']);

    if (!empty($_FILES['AlbumCover']['name'])) {
        $imageName = time() . '_' . basename($_FILES['AlbumCover']['name']);
        $targetDir = "../../assets/uploads/";
        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0755, true);
        }
        $targetFile = $targetDir . $imageName;

        $imageFileType = strtolower(pathinfo($targetFile, PATHINFO_EXTENSION));
        $allowedExtensions = array("jpg", "jpeg", "png", "gif");

        if (in_array($imageFileType, $allowedExtensions)) {
            if (move_uploaded_file($_FILES['AlbumCover']['tmp_name'], $targetFile)) {
                $imgPath = "assets/uploads/$imageName";

                $query = "INSERT INTO products 
                    (albumName, artistName, price, quantity, albumDesc, category_id, AlbumCover) 
                    VALUES ('$albumName', '$artistName', '$price', '$quantity', '$albumDesc', '$category_id', '$imgPath')";

                if (mysqli_query($conn, $query)) {
                    $success = "Product added successfully!";
                } else {
                    $error = "Database error: " . mysqli_error($conn);
                }
            } else {
                $error = "Error uploading file. (Check folder permissions)";
            }
        } else {
            $error = "Invalid file extension. Allowed: jpg, jpeg, png, gif.";
        }
    } else {
        $error = "Please select an image to upload.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body {
            background: linear-gradient(0deg, #327c99, #24221f);
            color: #fff;
            font-family: "Poppins";
        }

        .form-container {
            width: 85%;
            max-width: 700px;
            margin: 60px auto;
            padding: 30px;
            background: rgba(255, 255, 255, 0.08);
            border-radius: 20px;
            backdrop-filter: blur(10px);
        }

        label {
            font-weight: 500;
        }

        .form-control {
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            border-radius: 10px;
            border: 1px solid rgba(255, 255, 255, 0.262);
        }

        .btn-submit {
            width: 100%;
            padding: 10px;
            border-radius: 10px;
            background: rgba(255, 255, 255, 0.3);
            color: #fff;
            border: none;
        }

        .alert {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="form-container">
        <h2>Add New Product</h2>

        <?php if (isset($success)) echo "<div class='alert alert-success'>$success</div>"; ?>
        <?php if (isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

        <form method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label>Album Name</label>
                <input type="text" name="albumName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Artist Name</label>
                <input type="text" name="artistName" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Price</label>
                <input type="number" step="0.01" name="price" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Quantity</label>
                <input type="number" name="quantity" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Description</label>
                <textarea name="albumDesc" class="form-control" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label>Category ID</label>
                <input type="text" name="category_id" class="form-control" required>
            </div>
            <div class="mb-3">
                <label>Album Cover</label>
                <input type="file" name="AlbumCover" class="form-control" accept="image/*" required>
            </div>
            <button type="submit" name="submit" class="btn-submit">Add Product</button>
        </form>

        <a href="dashboard.php" style="display:block; text-align:center; margin-top:10px; color:#fff;">← Back to Dashboard</a>
    </div>
</body>

</html>