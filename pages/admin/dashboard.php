<?php
session_start();
include '../../includes/db.php';

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
  header("Location: ../auth/auth.php");
  exit();
}

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
  <link rel="stylesheet" href="../../assets/css/style.css">
  <link rel="stylesheet" href="../../assets/css/dashboard.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
  <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@600&display=swap" rel="stylesheet">
  <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body>

  <nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid">
      <a class="navbar-logo" href="../../pages/index.php">EchoTone</a>
      <div class="ms-auto d-flex align-items-center gap-2">
        <a href="../../logout.php" class="btn icon-btn">
          <i class="fa-regular fa-user"> Logout</i>
        </a>
      </div>
    </div>
  </nav>

  <div class="admin-container">
    <div class="admin-header">
      <h1>Admin Panel</h1>
      <a href="addProduct.php" class="add-btn">Add Product</a>
    </div>

    <table>
      <thead>
        <tr>
          <th>Image</th>
          <th>Album Name</th>
          <th>Artist</th>
          <th>Price</th>
          <th>Quantity</th>
          <th>Description</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><img src="../../<?= htmlspecialchars($row['AlbumCover']); ?>" class="product-img" alt="Album"></td>
            <td><?= htmlspecialchars($row['albumName']); ?></td>
            <td><?= htmlspecialchars($row['artistName']); ?></td>
            <td><?= $row['price']; ?> <img src="../../assets/img/sar.png" class="price-icon"></td>
            <td><?= $row['quantity']; ?></td>
            <td><?= htmlspecialchars($row['albumDesc']); ?></td>
            <td>
              <a href="editProduct.php?id=<?= $row['id']; ?>" class="btn-edit">Edit</a>
              <a href="#" class="btn-delete" onclick="confirmDelete(<?= $row['id']; ?>)">Delete</a>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>
  <?php include '../../includes/footer.php'; ?>
  <script>
    function confirmDelete(id) {
      Swal.fire({
        html: `
        <i class="fa-solid fa-circle-check" 
        style="font-size: 70px; color: rgb(2, 230, 255); margin-bottom: 15px;"></i>
        <h2 style="color:#ddd;">Are you sure?</h2>
        <p style="color:#ddd;">This product will be permanently deleted.</p>
    `,
        customClass: {
          popup: 'blur-popup'
        },
        showCancelButton: true,
        confirmButtonText: "Delete",
        cancelButtonText: "Cancel",
        confirmButtonColor: "rgb(2, 230, 255)",
        cancelButtonColor: "#6c757d",
        background: "rgba(249, 249, 249, 0.3)",
      }).then((result) => {
        if (result.isConfirmed) {
          window.location.href = `deleteProduct.php?id=${id}`;
        }
      });
    }
  </script>

</body>

</html>