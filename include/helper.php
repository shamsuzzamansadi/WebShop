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
        <div class="alert alert-primary" role="alert">
            {$_SESSION['message']}
        </div>
HTML;
        echo $alert;
        unset($_SESSION['message']);
    }
}

function count_items() {
    $count = 0;
    for ($i=1; $i < 11; $i++) { 
        # code...
        if (isset($_SESSION['id'])) {
            if (isset($_SESSION['cart_' . $i])) {
                $count += $_SESSION['cart_' . $i]; 
            }
        }
        else {
            if (isset($_COOKIE['cart_' . $i])) {
                $count += $_COOKIE['cart_' . $i]; 
            }
        }

    }
    return $count;
}
?>
