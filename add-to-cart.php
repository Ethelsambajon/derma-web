<?php
session_start();
include '../dbcon.php';

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


if (isset($_POST['product_id'], $_POST['quantity'], $_POST['size'], $_SESSION['customer_id'])) {
    $customerId = $_SESSION['customer_id'];
    $productId = $_POST['product_id'];
    $quantity = $_POST['quantity'];
    $size = $_POST['size'];

    // Begin transaction
    mysqli_begin_transaction($connection);

    try {
        // Retrieve product price from the database
        $sql_product_price = "SELECT price FROM products WHERE product_id = ?";
        $stmt_product_price = mysqli_prepare($connection, $sql_product_price);
        mysqli_stmt_bind_param($stmt_product_price, "i", $productId);
        mysqli_stmt_execute($stmt_product_price);
        $result_product_price = mysqli_stmt_get_result($stmt_product_price);
        $row_product_price = mysqli_fetch_assoc($result_product_price);
        $productPrice = $row_product_price['price'];

        // Calculate total amount
        $totalAmount = $productPrice * $quantity;

        // Check if the customer has enough money
        $sql_check_money = "SELECT amount_of_money FROM customers WHERE customer_id = ?";
        $stmt_check_money = mysqli_prepare($connection, $sql_check_money);
        mysqli_stmt_bind_param($stmt_check_money, "i", $customerId);
        mysqli_stmt_execute($stmt_check_money);
        $result_check_money = mysqli_stmt_get_result($stmt_check_money);
        $row_check_money = mysqli_fetch_assoc($result_check_money);
        $customerMoney = $row_check_money['amount_of_money'];

            // Add item to cart
            $sql_add_to_cart = "INSERT INTO cart (customer_id, product_id, quantity, size) VALUES (?, ?, ?, ?)";
            $stmt_add_to_cart = mysqli_prepare($connection, $sql_add_to_cart);
            mysqli_stmt_bind_param($stmt_add_to_cart, "iiis", $customerId, $productId, $quantity, $size);
            mysqli_stmt_execute($stmt_add_to_cart);

            // Check if item added to cart
            if (mysqli_stmt_affected_rows($stmt_add_to_cart) === 0) {
                throw new Exception("Failed to add item to cart.");
            }

            // Commit transaction
            mysqli_commit($connection);

            // Redirect to customers page with success message
            echo "
            <script>
            Swal.fire({
                icon: 'success',
                title: 'Product Added to Cart',
                showConfirmButton: false,
                timer: 1500,
                customClass: {
                    popup: 'bg-white',
                    title: 'text-success',
                },
                buttonsStyling: false,
                timerProgressBar: true,
            }).then(function() {
                window.location.href='customers-page.php?success=1';
            });
            </script>";
        exit();
    } catch (Exception $e) {
        // Rollback transaction
        mysqli_rollback($connection);

        // Redirect to customers page with error message
        header("Location: customers-page.php?error=" . urlencode($e->getMessage()));
        exit();
    }
} else {
    // Invalid request, redirect to customers page
    header("Location: customers-page.php");
    exit();
}
?>
