<!DOCTYPE html>
<?php
    require "include/incProducts.php";
?>

<html>
    <br>
    <div class="container">
        <div class="row">
            <div class="col-4">
                <div class="card">
                    <div class="card-header">
                        Products
                    </div>
                    <div class="list-group list-group-flush">
                        <?php get_products(); ?>
                    </div>
                </div>

            </div>
            <div class="col-8">
                <?php get_product_detail(); ?>
            </div>
        </div>
    </div>

</html>