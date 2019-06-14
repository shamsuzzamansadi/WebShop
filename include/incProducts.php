<?php

    //session_start();
function get_products() {
    require_once 'incDbh.php';
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
            while($row = $result->fetch_assoc()) {
                if(isset($_GET['product']) && $row['id']==$_GET['product']) {
                    $active = 'active';
                }
                else {
                    $active = '';
                }
                $product = <<<HTML
                    <a href="index.php?product={$row['id']}" class="list-group-item list-group-item-action {$active} d-flex justify-content-between align-items-center">
                        {$row['product_name']}
                        <span class="badge badge-primary badge-pill">{$row['product_stock']}</span>
                    </a>
HTML;
                
                echo $product;
            }
        }
        $stmt->close();
    }
}

function get_product_detail() {
    require 'incDbh.php';
    // require 'helper.php';
    $returnurl = $_SERVER['REQUEST_URI'];
    display_message();
    if(!isset($_GET['product'])) {
        $alert = <<<HTML
                <div class="alert alert-danger" role="alert">
                  Select product in list
                </div>
HTML;
        echo $alert;
        exit();
    }
    $id = $_GET['product'];
    $sqlquery = "SELECT * FROM tbl_product WHERE id = ?";
    $stmt = mysqli_stmt_init($connection);
    if(!$stmt->prepare($sqlquery))
    {
        header("Location: ../error.php?error=sqlerror");
        exit();
    }
    else {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        if($result->num_rows == 1) {
            while($row = $result->fetch_assoc()) {
                $product = <<<HTML
                <form method="post" action="cart.php?action=add&product={$row['id']}">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">{$row['product_name']}</h5>
                        <p class="card-text">{$row['product_desc']}</p>
                        <span class="card-text">$ {$row['product_price']}</span>
                        <input type="text" hidden name="returnurl" value={$returnurl}/>
                        <input type="text" name="quantity" value="1" size="2"/>
                        <input type="submit" class="btn btn-primary" value="Add to cart"/>
                    </div>
                </div>
                </form>
HTML;
                echo $product;
            }
        }
        $stmt->close();

    }
}
?>