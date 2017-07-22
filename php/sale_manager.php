<?php

require_once('definitions.php');
require_once('global_functions.php');

Class SaleManager
{
    function validate_imei($imei)
    {
        if (!preg_match('/^[0-9]{15}$/', $imei)) return false;
        $sum = 0;
        for ($i = 0; $i < 14; $i++) {
            $num = $imei[$i];
            if (($i % 2) != 0) {
                $num = $imei[$i] * 2;
                if ($num > 9) {
                    $num = (string) $num;
                    $num = $num[0] + $num[1];
                }
            }
            $sum += $num;
        }
        if ((($sum + $imei[14]) % 10) != 0) return false;
        return true;
    }

    function listSales($from_id = NULL, $to_id = NULL)
    {

        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        $sale_query = "";
        if (isset($from_id, $to_id)) {
            $sanitized_from_id = $link->escape_string($from_id);
            $sanitized_to_id = $link->escape_string($to_id);
            $sale_query = "SELECT * FROM sales WHERE sale_id BETWEEN " . $sanitized_from_id . " AND " . $sanitized_to_id ;
        } else {
            $sale_query = "SELECT * FROM sales" ;
        }
        $sale_result = $link->query($sale_query)  or die("Error in the consult.." . mysqli_error($link));

        $result = array();

        while ($sale_row = $sale_result->fetch_assoc())
        {
            $product_query = "SELECT * FROM products WHERE product_id=" . $sale_row['product_id'];
            $product_result = $link->query($product_query) or die("Error in the consult.." . mysqli_error($link));
            while ($product_row = $product_result->fetch_assoc())
            {
                $appended_partial = ($sale_row + $product_row);
                $store_query = "SELECT * FROM stores WHERE store_id=" . $sale_row['store_id'];
                $store_result = $link->query($store_query) or die("Error in the consult.." . mysqli_error($link));
                while ($store_row = $store_result->fetch_assoc())
                {
                    $appended_final = ($appended_partial + $store_row);
                }
            }
            unset($appended_final['store_id']);
            unset($appended_final['store_contact_number']);
            unset($appended_final['store_address']);
            $result[] = $appended_final;
        }
        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    function createSale($customer_name, $store_name, $product, $color, $quantity, $date, $imei)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (isset($customer_name, $store_name, $product, $quantity, $date, $imei))  {
            //Get the IDs from the name
            $store_id = store_id_from_store_name($store_name);
            $product_id = product_id_from_product_name($product, $color);

            //The insertion
            $statement = $link->prepare("INSERT INTO sales (customer_name, product_id, store_id, quantity, date, imei) VALUES (?, ?, ?, ?, ?, ?)");
            $statement->bind_param("siiisi", $customer_name, $product_id, $store_id, $quantity, $date, $imei);
            $statement->execute();
            //Update sale ID, so as to maintain continuancy.
            $counter_query = "SET @count = 0; UPDATE `sales` SET `sale_id` = @count:= @count + 1; ALTER TABLE `sales` AUTO_INCREMENT = 1;";
            $link->multi_query($counter_query);
        } else {
            print "Error creating the sale";
        }
    }

    function removeSale($sale_id)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($sale_id))  {
            //The insertion
            $statement = $link->prepare("DELETE FROM sales WHERE sale_id=?");
            $statement->bind_param("i", $sale_id);
            $statement->execute();
            //Update sale ID, so as to maintain continuancy.
            $counter_query = "SET @count = 0; UPDATE `sales` SET `sale_id` = @count:= @count + 1; ALTER TABLE `sales` AUTO_INCREMENT = 1;";
            $link->multi_query($counter_query);
        } else {
            print "Error deleting the sale";
        }
    }
}

?>