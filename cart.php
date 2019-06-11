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
                ?>
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
                        <?php 
                            show_cart();
                        ?>
                    </tbody>
                </table>

            </div>
        </div>
    </div>

</html>