<?php
    require "header.php";
    require 'include/incDbh.php';
    if (isset($_SESSION['id']) && isset($_GET['address']) && isset($_GET['payment']) && isset($_GET['delivery'])) 
    {
        $sqlquery = "INSERT INTO tbl_orders (user_id, address, payment, delivery) VALUES (?, ?, ?, ?)";
        $stmt = mysqli_stmt_init($connection);
        if(!$stmt->prepare($sqlquery))
        {
            header("Location: ../error.php?error=sqlerror");
            exit();
        }
        else {
            $user_id = (int) $_SESSION['id'];
            $address = $_GET['address'];
            $payment = $_GET['payment'];
            $delivery = $_GET['delivery'];
            $stmt->bind_param("isss", $user_id, $address, $payment, $delivery);
            $stmt->execute();

            $get_order_id = "SELECT * FROM tbl_orders ORDER BY id DESC LIMIT 1";
            $select_order_stmt = mysqli_stmt_init($connection);
            if(!$select_order_stmt->prepare($get_order_id))
            {
                header("Location: ../error.php?error=sqlerror");
                exit();
            }
            else {
                $select_order_stmt->execute();
                $result = $select_order_stmt->get_result();
                if($result->num_rows == 1) {
                    while($row = $result->fetch_assoc()) {
                        $order_id = $row['id'];
                        $update_basket_sql = "UPDATE tbl_basket SET order_id = ? WHERE order_id IS NULL";
                        $update_stmt = mysqli_stmt_init($connection);
                        if(!$update_stmt->prepare($update_basket_sql))
                        {
                            header("Location: ../error.php?error=sqlerror");
                            exit();
                        }
                        else {
                            $update_stmt->bind_param("i", $order_id);
                            $update_stmt->execute();
                            for ($i=1; $i < 11; $i++) { 
                                # code...
                                if (isset($_SESSION['cart_' . $i])) {
                                    $quantity = $_SESSION['cart_' . $i];
                                    unset($_SESSION['cart_' . $i]);
                                    $update_product_sql = "UPDATE tbl_product SET product_stock = product_stock - ? WHERE id = ?";
                                    $update_product_stmt =  mysqli_stmt_init($connection);
                                    if(!$update_product_stmt->prepare($update_product_sql))
                                    {
                                        header("Location: ../error.php?error=sqlerror");
                                        exit();
                                    }
                                    else {
                                        $update_product_stmt->bind_param("ii", $quantity, $i);
                                        $update_product_stmt->execute();
                                    }
                                }
                            }
                            set_message("Order id = " . $order_id . " success");
                            header("Location: ../webshop/index.php");
                            exit();
                        }
                    }
                }
            }

            $stmt->close();
            $update_stmt->close();
        }
    } elseif (isset($_SESSION['id'])) {
        $user_id = (int) $_SESSION['id'];
        $order_sql = "SELECT * FROM tbl_orders WHERE user_id = ?";
        $order_stmt = mysqli_stmt_init($connection);
        if(!$order_stmt->prepare($order_sql))
        {
            header("Location: ../error.php?error=sqlerror");
            exit();
        }
        else {
            
            $order_stmt->bind_param("i", $user_id);
            $order_stmt->execute();
            $order_result = $order_stmt->get_result();
            if($order_result->num_rows > 0) {
                while($order = $order_result->fetch_assoc()) {
                    $head = <<<HTML
                        <p>Order id: {$order['id']}</p>
                        <p>Address: {$order['payment']}</p>
                        <p>Delivery: {$order['delivery']}</p>
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                <th scope="col">#</th>
                                <th scope="col">Product id</th>
                                <th scope="col">Quantity</th>
                                <th></th>
                                </tr>
                            </thead>
                            <tbody>
HTML;
                    $order_id = $order['id'];
                    $basket_sql = "SELECT * FROM tbl_basket WHERE order_id = ?";
                    $basket_stmt =  mysqli_stmt_init($connection);
                    if(!$basket_stmt->prepare($basket_sql))
                    {
                        header("Location: ../error.php?error=sqlerror");
                        exit();
                    }
                    else {
                        $basket_stmt->bind_param("i", $order_id);
                        $basket_stmt->execute();
                        $basket_result = $basket_stmt->get_result();
                        if($basket_result->num_rows > 0) {
                            $index = 0;
                            echo $head;
                            while($basket = $basket_result->fetch_assoc()) {
                                $index ++;
                                $body = <<<HTML
                                <tr>
                                    <th scope="row">{$index}</th>
                                    <td>
                                        <a href="index.php?product={$basket['product_id']}">
                                            {$basket['product_id']}
                                        </a>
                                    </td>
                                    <td>{$basket['amount']}</td>
                                </tr>
HTML;
                                echo $body;

                            }
                        }
                    }

                    $foot = <<<HTML
                            </tbody>
                        </table>
                        <hr>
HTML;
                    echo $foot;
                }
            }
            else {
                $empty = <<<HTML
                    <p>Your order is empty.</p>
HTML;
                echo $empty;
            }
        }
    }
    else {
        header("Location:../webshop/index.php");
        exit();
    }
?>