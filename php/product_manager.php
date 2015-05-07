<?php

require_once('definitions.php');

Class ProductManager
{

    function updateProduct($product_id, $product, $color, $cost_price, $selling_price)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        if (isset($product_id, $product, $color, $cost_price, $selling_price))  {
            //The insertion
            $statement = $link->prepare("UPDATE products SET product=?, cost_price=?, selling_price=? WHERE product_id=?");
            $statement->bind_param("ssiii", $product, $color, $cost_price, $selling_price, $product_id);
            $statement->execute();
        } else {
            print "Error creating the transfer";
        }
    }

    function listProducts($from_id = NULL, $to_id = NULL)
    {

        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);

        header("Cache-Control: no-cache,no-store");

        $product_query = "";
        if (isset($from_id, $to_id)) {
            $sanitized_from_id = $link->escape_string($from_id);
            $sanitized_to_id = $link->escape_string($to_id);
            $product_query = "SELECT * FROM products WHERE product_id BETWEEN " . $sanitized_from_id . " AND " . $sanitized_to_id ;
        } else {
            $product_query = "SELECT * FROM products" ;
        }

        $product_result = $link->query($product_query)  or die("Error in the consult.." . mysqli_error($link));

        $result = array();

        while ($product_row = $product_result->fetch_assoc())
        {
            $result[] = $product_row;
        }

        return json_encode($result, JSON_NUMERIC_CHECK);
    }

    function createProduct($product_name, $color, $cost_price, $selling_price)
    {
        if (isset($product_name, $color, $cost_price, $selling_price))  {
            
            $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
            
            //The insertion
			$statement = $link->prepare("INSERT INTO products (product, color, cost_price, selling_price) VALUES (?, ?, ?, ?)");
			$statement->bind_param("ssii", $product_name, $color, $cost_price, $selling_price);
			$statement->execute();
			//Update product ID, so as to maintain continuancy.
			$counter_query = "SET @count = 0; UPDATE `products` SET `product_id` = @count:= @count + 1; ALTER TABLE `products` AUTO_INCREMENT = 1;";
			$link->multi_query($counter_query);
            
        } else {
            print "Error creating the product";
        }
    }

    function removeProduct($product_id)
    {
        $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
        if (isset($product_id))  {
            //The insertion
            $statement = $link->prepare("DELETE FROM products WHERE product_id=?");
            $statement->bind_param("i", $product_id);
            $statement->execute();
        } else {
            print "Error deleting the product";
        }
    }
}

?>