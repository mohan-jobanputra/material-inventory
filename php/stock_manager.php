<?php
require_once('definitions.php');
require_once('global_functions.php');

Class StockManager {
    function listStock()
    {

        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $product_query = "SELECT product_id, product, color FROM products";
        $product_result = $link->query($product_query) or die("Error in the consult..[Stocks-List-P]" . mysqli_error($link));

        $result = array();

        while ($product_row = $product_result->fetch_assoc())
        {
            $product_id = $product_row['product_id'];

            $store_query = "SELECT store_id, store_name FROM stores";
            $store_result = $link->query($store_query) or die("Error in the consult..[Stocks-List-S]" . mysqli_error($link));

            while ($store_row = $store_result->fetch_assoc()) {
                $store_id = $store_row['store_id'];

                $purchase_query = "SELECT quantity FROM purchases WHERE product_id=" . $product_id . " AND store_id=" . $store_id;
                $purchase_result = $link->query($purchase_query) or die("Error in the consult..[Stocks-List-Pu]" . mysqli_error($link));

                $purchase_quantity = 0;
                while ($purchase_row = $purchase_result->fetch_assoc()) {
                    $purchase_quantity += intval($purchase_row["quantity"]);
                }

                $sale_query = "SELECT quantity FROM sales WHERE product_id=" . $product_id . " AND store_id=" . $store_id;
                $sale_result = $link->query($sale_query) or die("Error in the consult..[Stocks-List-Sa]" . mysqli_error($link));

                $sale_quantity = 0;
                while ($sale_row = $sale_result->fetch_assoc()) {
                    $sale_quantity += intval($sale_row["quantity"]);
                }

                $transfer_sent_query = "SELECT quantity FROM transfers WHERE product_id=" . $product_id . " AND from_store_id=" . $store_id;
                $transfer_sent_result = $link->query($transfer_sent_query) or die("Error in the consult..[Stocks-List-Ts]" . mysqli_error($link));

                $transfer_sent_quantity = 0;
                while ($transfer_sent_row = $transfer_sent_result->fetch_assoc()) {
                    $transfer_sent_quantity += intval($transfer_sent_row["quantity"]);
                }

                $transfer_recieved_query = "SELECT quantity FROM transfers WHERE product_id=" . $product_id . " AND to_store_id=" . $store_id;
                $transfer_recieved_result = $link->query($transfer_recieved_query) or die("Error in the consult..[Stocks-List-Tf]" . mysqli_error($link));

                $transfer_recieved_quantity = 0;
                while ($transfer_recieved_row = $transfer_recieved_result->fetch_assoc()) {
                    $transfer_recieved_quantity += intval($transfer_recieved_row["quantity"]);
                }

                $stock_in_shop = ( $purchase_quantity + $transfer_recieved_quantity ) - ( $sale_quantity + $transfer_sent_quantity );

                $sub_result = array();
                $sub_result['product_name'] = $product_row['product'];
                $sub_result['color'] = $product_row['color'];
                $sub_result['store_name'] = $store_row['store_name'];
                $sub_result['quantity'] = $stock_in_shop;

                $result[] = $sub_result;
            }
        }
        return json_encode($result, JSON_NUMERIC_CHECK);
    }
}

?>