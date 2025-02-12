<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['username']) || $_SESSION['role'] != 'admin') {
    header("Location: ../admin-login.php");
    exit();
}

include '../../dbcon.php';

// Query to fetch messages from customers
$sqlMessages = "SELECT * FROM customer_messages ORDER BY message_date DESC";
$resultMessages = mysqli_query($connection, $sqlMessages);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Messages</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="../../design.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

</head>

<body style = "background-color: violet">
    <!-- Navigation bar -->
    <nav class="navbar navbar-expand-lg navbar-dark ">
        <div class="container-fluid">
            <a class="navbar-brand" href="../admin-page.php">
            <img src="../../resources/dmlogo.jpg" alt="Starbucks Logo" class="logo" style="width: 100px; height: 40px;">
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link" href="../admin-page.php"><i class="bi bi-house"></i> Dashboard</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link " href="../customers/customers-list.php"><i class="bi bi-people"></i> Customers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../products/products-list.php"><i class="bi bi-box-seam"></i> Products</a>
                    </li>
                    <li class="nav-item dropdown-center">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="orderDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                        <i class="bi bi-cart"></i> Orders
                        </a>
                        <ul class="dropdown-menu" aria-labelledby="orderDropdownMenuLink">
                            <li><a class="dropdown-item" href="../orders/orders-list.php">Approved</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../orders/declined-list.php">Declined</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active bg-secondary rounded" href="customer-messages.php"><i class="bi bi-envelope"></i> Customer Messages</a>
                    </li>
                </ul>
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link dropdown-toggle" href="#" role="button" id="navbarDropdownMenuLink" data-bs-toggle="dropdown" aria-expanded="false">
                            <i class="bi bi-person"></i> Settings
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdownMenuLink">
                        <li><a class="dropdown-item" href="../profile.php">Profile</a></li>
                            <li><hr class="dropdown-divider"></li>
                            <li><a class="dropdown-item" href="../../logout.php">Logout</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Page content -->
    <div class="container mt-4 table-responsive">
        <h1>Customer Messages</h1>

        <!-- Form to clear all messages -->
        <form action="clear-all-messages.php" method="POST" style="margin-bottom: 20px;">
            <button type="submit" class="btn btn-danger">Clear All Messages</button>
        </form>

        <!-- Messages table -->
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Customer Name</th>
                    <th>Customer Email</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Action</th> <!-- Add an action column -->
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultMessages)) : ?>
                    <tr>
                        <td><?php echo $row['customer_name']; ?></td>
                        <td><?php echo $row['customer_email']; ?></td>
                        <td><?php echo $row['message']; ?></td>
                        <td><?php echo $row['message_date']; ?></td>
                        <td>
                            <!-- Delete button -->
                            <form action="delete-message.php" method="POST" style="display: inline;">
                                <input type="hidden" name="message_id" value="<?php echo $row['message_id']; ?>">
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>

</html>
