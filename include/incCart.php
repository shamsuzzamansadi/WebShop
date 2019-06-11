<?php
    function show_cart() {
        // session_start();
        require 'incDbh.php';
        $sqlquery = "SELECT * FROM tbl_product";
        $stmt = mysqli_stmt_init($connection);
        if(!$stmt->prepare($sqlquery))
        {
            header("Location: ../index.php?error=sqlerror");
            exit();
        }
        else {
            $stmt->execute();
            $result = $stmt->get_result();
            if($result->num_rows > 0) {
                $i = 0;
                while($row = $result->fetch_assoc()) {
                    if (isset($_SESSION['cart_' . $row['id']])) {
                        $i++;
                        $total_price = (int) $row['product_price'] * $_SESSION['cart_' . $row['id']];
                        $product_name = $row['product_name'];
                        $cart = <<<HTML
                        <tr>
                            <th scope="row">$i</th>
                            <td>{$row['product_name']}</td>
                            <td>{$_SESSION['cart_' . $row['id']]}</td>
                            <td>{$row['product_price']}</td>
                            <td>{$total_price}</td>
                            <td>
                                <form method="post" action="cart.php?action=remove&product={$row['id']}">
                                    <input type="text" hidden name="product_name" value="$product_name" />
                                    <input type="submit" class="btn btn-danger" value="X"/>
                                </form>
                            </td>
                        </tr>
HTML;
                    
                    echo $cart;
                    }
                }
            }
        }
    }

    require 'incDbh.php';
    require 'helper.php';
    if (isset($_GET["action"])) {
        switch($_GET["action"]) {
            case "add":
                if(isset($_GET["product"]) && isset($_POST["quantity"])) {
                    $id = (int) $_GET["product"];
                    $quantity = (int) $_POST['quantity'];
                    if ($quantity <= 0) {
                        if (session_status() == PHP_SESSION_NONE) {
                            session_start();
                        }
                        set_message("Quantity must be positive value.");
                        header("Location: ../webshop/index.php?product={$id}");
                        exit();
                    }
                    $sqlquery = "SELECT * FROM tbl_product WHERE id = ?";
                    $stmt = mysqli_stmt_init($connection);
                    if(!$stmt->prepare($sqlquery))
                    {
                        header("Location: ../index.php?error=sqlerror");
                        exit();
                    }
                    else {
                        $stmt->bind_param("i", $id);
                        $stmt->execute();
                        $result = $stmt->get_result();
                        if($result->num_rows == 1) {
                            while($row = $result->fetch_assoc()) {
                                if ($row['product_stock'] >= $quantity) {
                                    if (session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    if(!isset($_SESSION['cart_' . $id])) {
                                        $_SESSION['cart_' . $id] = 0;
                                    }
                                    $_SESSION['cart_' . $id] += $quantity;
                                    header("Location: ../webshop/index.php?product={$id}");
                                    exit();
                                }
                                else {
                                    if (session_status() == PHP_SESSION_NONE) {
                                        session_start();
                                    }
                                    set_message("We do not have enough " . $quantity . " " . $row['product_name']);
                                    header("Location: ../webshop/index.php?product={$id}");
                                    exit();
                                }
                            }
                        }
                    }
                }
            break;
            case "remove":
                if(isset($_GET["product"])) {
                    if (session_status() == PHP_SESSION_NONE) {
                        session_start();
                    }
                    unset($_SESSION['cart_' . $_GET["product"]]);
                    set_message("Removed product " . $_POST["product_name"] . " from cart.");
                    header("Location: ../webshop/cart.php");
                    exit();
                }
            break;
            default:
            break;
        }
    }
?>
