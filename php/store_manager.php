<?php

require_once('definitions.php');

Class StoreManager
{

    function updatePurchase($purchase_id, $store_id, $store_id, $quantity, $date) {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (isset($purchase_id, $store_id, $store_id, $quantity, $date))  {
            //The insertion
            $statement = $link->prepare("UPDATE purchases SET purchase_id=?, store_id=?, store_id=?, quantity=?, date=? WHERE purchase_id=?");
            $statement->bind_param("iiiisi", $purchase_id, $store_id, $store_id, $quantity, $date);
            $statement->execute();
        } else {
            print "Error creating the transfer";
        }
    }

    function listStores($from_id = NULL, $to_id = NULL)
    {

        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        header("Cache-Control: no-cache,no-store");

        $store_query = "";
        if (isset($from_id, $to_id)) {
            $sanitized_from_id = $link->escape_string($from_id);
            $sanitized_to_id = $link->escape_string($to_id);
            $store_query = "SELECT * FROM stores WHERE store_id BETWEEN " . $sanitized_from_id . " AND " . $sanitized_to_id ;
        } else {
            $store_query = "SELECT * FROM stores" ;
        }

        $store_result = $link->query($store_query)  or die("Error in the consult.." . mysqli_error($link));

        $result = array();

        while ($store_row = $store_result->fetch_assoc())
        {
            $id = $store_row['store_id'];
            $mod_id = str_replace('"', "", $id);
            unset($store_row['store_id']);
            $store_row['store_id'] = $mod_id;
            $result[] = $store_row;
        }

        return json_encode($result);
    }

    function createStore($name, $contact_number, $address)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (isset($name, $address, $contact_number))  {
            //The insertion
            $statement = $link->prepare("INSERT INTO stores (store_name, store_address, store_contact_number) VALUES (?, ?, ?)");
            $statement->bind_param("sss", $name, $address, $contact_number);
            $statement->execute();
            //Update purchase ID, so as to maintain continuancy.
            $counter_query = "SET @count = 0; UPDATE `stores` SET `store_id` = @count:= @count + 1; ALTER TABLE `stores` AUTO_INCREMENT = 1;";
            $link->multi_query($counter_query);
        } else {
            print "Error creating the store";
        }
    }

    function removeStore($store_id)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($store_id))  {
            //The insertion
            $statement = $link->prepare("DELETE FROM stores WHERE store_id=?");
            $statement->bind_param("i", $store_id);
            $statement->execute();
        } else {
            print "Error deleting the store";
        }
    }
}

?>