<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin-login.php");
    exit();
}

include '../../dbcon.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <!-- Include SweetAlert2 library -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the request ID from the POST data
    $request_id = $_POST['request_id'];

    // Retrieve the request information
    $sql_request_info = "SELECT r.*, p.price, c.customer_id, r.size, r.request_quantity, p.product_id
                         FROM requests r
                         INNER JOIN products p ON r.product_id = p.product_id
                         INNER JOIN customers c ON r.customer_id = c.customer_id
                         WHERE r.request_id = ?";
    $stmt_request_info = mysqli_prepare($connection, $sql_request_info);
    mysqli_stmt_bind_param($stmt_request_info, "i", $request_id);
    mysqli_stmt_execute($stmt_request_info);
    $result_request_info = mysqli_stmt_get_result($stmt_request_info);
    $row_request_info = mysqli_fetch_assoc($result_request_info);

    // Calculate the total amount based on the product price and request quantity
    $total_amount = $row_request_info['price'] * $row_request_info['request_quantity'];

    // Update the customer's amount_of_money
    $customer_id = $row_request_info['customer_id'];
    $sql_update_amount = "UPDATE customers SET amount_of_money = amount_of_money - ? WHERE customer_id = ?";
    $stmt_update_amount = mysqli_prepare($connection, $sql_update_amount);
    mysqli_stmt_bind_param($stmt_update_amount, "di", $total_amount, $customer_id);
    mysqli_stmt_execute($stmt_update_amount);

    // Add the total amount to the admin's amount_of_money
    $admin_id = $_SESSION['admin_id'];
    $sql_admin_money = "SELECT amount_of_money FROM admins WHERE admin_id = ?";
    $stmt_admin_money = mysqli_prepare($connection, $sql_admin_money);
    mysqli_stmt_bind_param($stmt_admin_money, "i", $admin_id);
    mysqli_stmt_execute($stmt_admin_money);
    $result_admin_money = mysqli_stmt_get_result($stmt_admin_money);
    $row_admin_money = mysqli_fetch_assoc($result_admin_money);
    $adminMoney = $row_admin_money['amount_of_money'];

    $newAdminMoney = $adminMoney + $total_amount;
    $sql_add_admin_money = "UPDATE admins SET amount_of_money = ? WHERE admin_id = ?";
    $stmt_add_admin_money = mysqli_prepare($connection, $sql_add_admin_money);
    mysqli_stmt_bind_param($stmt_add_admin_money, "di", $newAdminMoney, $admin_id);
    mysqli_stmt_execute($stmt_add_admin_money);

    // Insert the approved request into the orders table
    $sql_insert_order = "INSERT INTO orders (customer_id, total_amount) VALUES (?, ?)";
    $stmt_insert_order = mysqli_prepare($connection, $sql_insert_order);
    mysqli_stmt_bind_param($stmt_insert_order, "id", $customer_id, $total_amount);
    mysqli_stmt_execute($stmt_insert_order);

    // Update the request status to approved in the database
    $sql_update_request = "UPDATE requests SET status = 'approved' WHERE request_id = ?";
    $stmt_update_request = mysqli_prepare($connection, $sql_update_request);
    mysqli_stmt_bind_param($stmt_update_request, "i", $request_id);
    mysqli_stmt_execute($stmt_update_request);

    // Subtract the request_quantity from the product_sizes table
    $size = $row_request_info['size'];
    $request_quantity = $row_request_info['request_quantity'];
    $product_id = $row_request_info['product_id'];
    
    $sql_update_size = "UPDATE product_sizes SET quantity = quantity - ? WHERE product_id = ? AND size = ?";
    $stmt_update_size = mysqli_prepare($connection, $sql_update_size);
    mysqli_stmt_bind_param($stmt_update_size, "iis", $request_quantity, $product_id, $size);
    mysqli_stmt_execute($stmt_update_size);

      // Redirect back to the admin dashboard
      echo "<script>
      Swal.fire({
          icon: 'success',
          title: 'Request Approved!',
          showConfirmButton: false,
          timer: 1500
      }).then(function() {
          window.location.href='../admin-page.php';
      });
  </script>";
    exit();
}
?>
