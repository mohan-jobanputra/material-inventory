<?php

require_once('definitions.php');

Class PurchaseManager
{
    function updatePurchase($purchase_id, $product_id, $store_id, $quantity, $date, $rate) {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (isset($purchase_id, $product_id, $store_id, $quantity, $date, $rate))  {
            //The insertion
            $statement = $link->prepare("UPDATE purchases SET product_id=?, store_id=?, quantity=?, date=?, rate=? WHERE purchase_id=?");
            $statement->bind_param("iiisii", $product_id, $store_id, $quantity, $date, $rate, $purchase_id);
            $statement->execute();
        } else {
            print "Error creating the transfer";
        }
    }

    function listPurchases($from_id = NULL, $to_id = NULL)
    {

        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        header("Cache-Control: no-cache,no-store");

        $purchase_query = "";
        if (isset($from_id, $to_id)) {
            $sanitized_from_id = $link->escape_string($from_id);
            $sanitized_to_id = $link->escape_string($to_id);
            $purchase_query = "SELECT * FROM purchases WHERE purchase_id BETWEEN " . $sanitized_from_id . " AND " . $sanitized_to_id ;
        } else {
            $purchase_query = "SELECT * FROM purchases" ;
        }
        $purchase_result = $link->query($purchase_query)  or die("Error in the consult.." . mysqli_error($link));

        $result = array();

        while ($purchase_row = $purchase_result->fetch_assoc())
        {
            $product_query = "SELECT * FROM products WHERE product_id=" . $purchase_row['product_id'];
            $product_result = $link->query($product_query) or die("Error in the consult.." . mysqli_error($link));
            while ($product_row = $product_result->fetch_assoc())
            {
                $appended_partial = ($purchase_row + $product_row);
                $store_query = "SELECT * FROM stores WHERE store_id=" . $purchase_row['store_id'];
                $store_result = $link->query($store_query) or die("Error in the consult.." . mysqli_error($link));
                while ($store_row = $store_result->fetch_assoc())
                {
                    $appended_final = ($appended_partial + $store_row);
                    unset($appended_final['store_id']);
                    unset($appended_final['store_contact_number']);
                    unset($appended_final['store_address']);
                    $result[] = $appended_final;
                }
            }
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    function createPurchase($store_name, $product_name, $color, $quantity, $date)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (isset($store_name, $product_name, $color, $quantity, $date))  {
            //Get the IDs from the name
            $store_id = store_id_from_store_name($store_name);
            $product_id = product_id_from_product_name($product_name, $color);

            //The insertion
            $statement = $link->prepare("INSERT INTO purchases (product_id, store_id, quantity, date) VALUES (?, ?, ?, ?)");
            $statement->bind_param("iiis", $product_id, $store_id, $quantity, $date);
            $statement->execute();
            //Update purchase ID, so as to maintain continuancy.
            $counter_query = "SET @count = 0; UPDATE `purchases` SET `purchase_id` = @count:= @count + 1; ALTER TABLE `purchases` AUTO_INCREMENT = 1;";
            $link->multi_query($counter_query);
        } else {
            print "Error creating the purchase";
        }
    }

    function removePurchase($purchase_id)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($purchase_id))  {
            //The insertion
            $statement = $link->prepare("DELETE FROM purchases WHERE purchase_id=?");
            $statement->bind_param("i", $purchase_id);
            $statement->execute();
            //Update purchase ID, so as to maintain continuancy.
            $counter_query = "SET @count = 0; UPDATE `purchases` SET `purchase_id` = @count:= @count + 1; ALTER TABLE `purchases` AUTO_INCREMENT = 1;";
            $link->multi_query($counter_query);
        } else {
            print "Error deleting the purchase";
        }
    }
}

?>