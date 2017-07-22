<?php

require_once('definitions.php');

Class TransferManager
{
    function updateTransfer($transfer_id, $product_id, $from_store_id, $to_store_id, $quantity, $date) {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (isset($transfer_id, $product_id, $from_store_id, $to_store_id, $quantity, $date))  {
            //The insertion
            $statement = $link->prepare("UPDATE transfers SET product_id=?, from_store_id=?, to_store_id=?, quantity=?, date=? WHERE transfer_id=?");
            $statement->bind_param("iiiisi", $product_id, $from_store_id, $to_store_id, $quantity, $date, $transfer_id);
            $statement->execute();
        } else {
            print "Error creating the transfer";
        }
    }

    function listTransfers($from_id = NULL, $to_id = NULL)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        header("Cache-Control: no-cache,no-store");

        $transfer_query = "";
        if (isset($from_id, $to_id)) {
            $sanitized_from_id = $link->escape_string($from_id);
            $sanitized_to_id = $link->escape_string($to_id);
            $transfer_query = "SELECT * FROM transfers WHERE transfer_id BETWEEN " . $sanitized_from_id . " AND " . $sanitized_to_id ;
        } else {
            $transfer_query = "SELECT * FROM transfers" ;
        }
        $transfer_result = $link->query($transfer_query)  or die("Error in the consult.." . mysqli_error($link));

        $result = array();

        while ($transfer_row = $transfer_result->fetch_assoc())
        {
            $product_query = "SELECT * FROM products WHERE product_id=" . $transfer_row['product_id'];
            $product_result = $link->query($product_query) or die("Error in the consult.." . mysqli_error($link));
            while ($product_row = $product_result->fetch_assoc())
            {
                $appended = ($transfer_row + $product_row);
                $store_query = "SELECT * FROM stores WHERE store_id=" . $transfer_row['from_store_id'] . " OR store_id=" . $transfer_row['to_store_id'];
                $store_result = $link->query($store_query) or die("Error in the consult.." . mysqli_error($link));
                while ($store_row = $store_result->fetch_assoc())
                {
                    $store_id = $store_row['store_id'];
                    if ($store_id == $transfer_row['from_store_id']) {
                        $appended['from_store_name'] = $store_row['store_name'];
                    } else if ($store_id == $transfer_row['to_store_id']) {
                        $appended['to_store_name'] = $store_row['store_name'];
                    }
                }
            }
            unset($appended['store_contact_number']);
            unset($appended['store_address']);
            unset($appended['cost_price']);
            unset($appended['selling_price']);
            $result[] = $appended;
        }
        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    function createTransfer($product_name, $color, $from_store_name, $to_store_name, $quantity, $date)
    {
        if (isset($product_name, $color, $from_store_name, $to_store_name, $quantity, $date))  {

            $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

            $product_id = product_id_from_product_name($product_name, $color);
            $from_store_id = store_id_from_store_name($from_store_name);
            $to_store_id = store_id_from_store_name($to_store_name);

            //The insertion
            $statement = $link->prepare("INSERT INTO transfers (product_id, from_store_id, to_store_id, quantity, date) VALUES (?, ?, ?, ?, ?)");
            $statement->bind_param("iiiis", $product_id, $from_store_id, $to_store_id, $quantity, $date);
            $statement->execute();
            //Update transfer ID, so as to maintain continuancy.
			$counter_query = "SET @count = 0; UPDATE `transfer` SET `transfer_id` = @count:= @count + 1; ALTER TABLE `transfers` AUTO_INCREMENT = 1;";
			$link->multi_query($counter_query);
        } else {
            print "Error creating the transfer";
        }
    }

    function removeTransfer($transfer_id)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($transfer_id))  {
            //The insertion
            $statement = $link->prepare("DELETE FROM transfers WHERE transfer_id=?");
            $statement->bind_param("i", $transfer_id);
            $statement->execute();
            //Update transfer ID, so as to maintain continuancy.
            $counter_query = "SET @count = 0; UPDATE `transfers` SET `transfer_id` = @count:= @count + 1; ALTER TABLE `transfers` AUTO_INCREMENT = 1;";
            $link->multi_query($counter_query);
        } else {
            print "Error deleting the transfer";
        }
    }
}

?>