<?php
session_start();
include '../dbcon.php';

// Check if the request method is POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Check if customer is logged in and selected_products is provided
    if (isset($_SESSION['customer_id']) && isset($_POST['selected_products'])) {
        $customerId = $_SESSION['customer_id'];
        $selectedProducts = json_decode($_POST['selected_products'], true);

        // Validate selected products data
        if (!empty($selectedProducts) && is_array($selectedProducts)) {
            // Construct the SQL query to delete selected products from the cart
            $deleteQuery = "DELETE FROM cart WHERE customer_id = ? AND product_id IN (";
            $placeholders = implode(',', array_fill(0, count($selectedProducts), '?'));
            $deleteQuery .= $placeholders . ")";

            // Prepare the statement
            $stmt = mysqli_prepare($connection, $deleteQuery);
            if ($stmt) {
                // Construct the type definition string dynamically based on the number of selected products
                $typeString = str_repeat('i', count($selectedProducts) + 1); // One for customer_id, rest for product_ids

                // Create an array with customer_id as the first parameter
                $bindParams = array($customerId);

                // Append product_ids to the bindParams array
                foreach ($selectedProducts as $productId) {
                    $bindParams[] = $productId;
                }

                // Bind parameters and execute the statement
                mysqli_stmt_bind_param($stmt, $typeString, ...$bindParams);
                if (mysqli_stmt_execute($stmt)) {
                    // Products successfully removed from cart
                    echo "
                    <script>
                        alert('Removed from the cart');
                        window.location.href='customers-page.php';
                    </script>
                    ";
                    exit();
                } else {
                    // Error executing the statement
                    echo "Error executing database operation.";
                    exit();
                }
            } else {
                // Error preparing the statement
                echo "Error preparing database statement.";
                exit();
            }
        } else {
            // No or invalid products selected
            echo "
            <script>
                alert('No valid products selected to remove from the cart.');
                window.location.href='customers-page.php';
            </script>";
            exit();
        }
    } else {
        // Customer not logged in or selected_products not provided
        header("Location: ../customers-login.php");
        exit();
    }
} else {
    // Invalid request method
    echo "Invalid request method.";
    exit();
}
?>
