<?php
function set_message($msg){
    if(!empty($msg)) {
        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}
    
    
function display_message() {
    if(isset($_SESSION['message'])) {
        $alert = <<<HTML
        <div class="alert alert-danger" role="alert">
            {$_SESSION['message']}
        </div>
HTML;
        echo $alert;
        unset($_SESSION['message']);
    }
}

function count_items() {
    for ($i=1; $i < 4; $i++) { 
        # code...
        $count = 0;
        if (isset($_SESSION['cart_' . $i])) {
            $count += $_SESSION['cart_' . $i]; 
        }
    }
    $cart = <<<HTML
        <a href="cart.php"><i class="fas fa-shopping-cart"></i>{$count}</a>
HTML;
    echo $cart;
    exit();
}
?>
