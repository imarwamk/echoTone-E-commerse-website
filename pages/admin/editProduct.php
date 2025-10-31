<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../auth/auth.php");
  exit();
}

$id = $_GET['id'] ?? null;
if (!$id) {
  header("Location: dashboard.php");
  exit();
}

$query = "SELECT * FROM products WHERE id = '$id'";
$result = mysqli_query($conn, $query);
$product = mysqli_fetch_assoc($result);

if (!$product) {
  die("Product not found!");
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $albumName = $_POST['albumName'];
  $albumDesc = $_POST['albumDesc'];
  $artistName = $_POST['artistName'];
  $price = $_POST['price'];
  $quantity = $_POST['quantity'];
  $category_id = $_POST['category_id'];

  if (!empty($_FILES['AlbumCover']['name'])) {
    $imageName = time() . '_' . basename($_FILES['AlbumCover']['name']);
    $targetDir = "../../assets/uploads/";
    if (!is_dir($targetDir)) {
      mkdir($targetDir, 0755, true); 
    }
    $targetFile = $targetDir . $imageName;

    if (move_uploaded_file($_FILES['AlbumCover']['tmp_name'], $targetFile)) {
      $updateImage = ", AlbumCover='assets/uploads/$imageName'";
    } else {
      echo "<script>alert('Failed to upload the new image. Please check folder permissions.');</script>";
      $updateImage = "";
    }
  } else {
    $updateImage = "";
  }

  $updateQuery = "UPDATE products SET 
        albumName='$albumName',
        albumDesc='$albumDesc',
        artistName='$artistName',
        price='$price',
        quantity='$quantity',
        category_id='$category_id'
        $updateImage
        WHERE id='$id'";

  if (mysqli_query($conn, $updateQuery)) {
    header("Location: dashboard.php");
    exit();
  } else {
    echo "<script>alert('Error updating product.');</script>";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Product</title>
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
  </style>
</head>

<body>
  <div class="form-container">
    <h2>Edit Product</h2>
    <form method="POST" enctype="multipart/form-data">
      <div class="mb-3">
        <label>Album Name</label>
        <input type="text" name="albumName" class="form-control" value="<?= htmlspecialchars($product['albumName']); ?>" required>
      </div>
      <div class="mb-3">
        <label>Description</label>
        <textarea name="albumDesc" class="form-control" rows="3" required><?= htmlspecialchars($product['albumDesc']); ?></textarea>
      </div>
      <div class="mb-3">
        <label>Artist Name</label>
        <input type="text" name="artistName" class="form-control" value="<?= htmlspecialchars($product['artistName']); ?>" required>
      </div>
      <div class="mb-3">
        <label>Price</label>
        <input type="number" name="price" class="form-control" value="<?= $product['price']; ?>" required>
      </div>
      <div class="mb-3">
        <label>Quantity</label>
        <input type="number" name="quantity" class="form-control" value="<?= $product['quantity']; ?>" required>
      </div>
      <div class="mb-3">
        <label>Category ID</label>
        <input type="text" name="category_id" class="form-control" value="<?= $product['category_id']; ?>" required>
      </div>
      <div class="mb-3">
        <label>Album Cover (optional)</label>
        <input type="file" name="AlbumCover" class="form-control">
      </div>
      <button type="submit" class="btn-submit">Update Product</button>
    </form>
    <a href="dashboard.php" style="display:block; text-align:center; margin-top:10px; color:#fff;">← Back to Dashboard</a>
  </div>
</body>

</html>