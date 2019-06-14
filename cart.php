<?php
    require "header.php";
    // require "include/helper.php";
    require "include/incCart.php";
?>

<html>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-12">
                <?php
                    display_message();
                    $table = <<<HTML
                    <table class="table table-hover">
                        <thead>
                            <tr>
                            <th scope="col">#</th>
                            <th scope="col">Product name</th>
                            <th scope="col">Quantity</th>
                            <th scope="col">Price $</th>
                            <th scope="col">Total price $</th>
                            <th></th>
                            </tr>
                        </thead>
                        <tbody>
HTML;
                    $table_footer = <<<HTML
                        </tbody>
                    </table>
                    <form method="post" action="checkout.php">
                        <input type="submit" class="btn btn-primary" value="Check out"/>
                    </form>
HTML;


                if (count_items() == 0) {
                    $alert = <<<HTML
                    <div class="alert alert-primary" role="alert">
                        Your shopping basket is empty.
                    </div>
HTML;
                    echo $alert;
                }
                else {
                    echo $table;
                    show_cart();
                    echo $table_footer;
                }
                ?>
            </div>
        </div>
    </div>

</html>