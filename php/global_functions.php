<?php

require_once('definitions.php');

function product_id_from_product_name($product_name, $color)
{
    $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    header("Cache-Control: no-cache,no-product");

    $sanitized_product_name = $link->escape_string($product_name);
    $sanitized_color = $link->escape_string($color);
    $product_query = 'SELECT * FROM products WHERE product="' . $sanitized_product_name . '" AND color="' . $sanitized_color . '";';
    $product_result = $link->query($product_query)  or die("Error in the consult.." . mysqli_error($link));

    while ($product_row = $product_result->fetch_assoc())
    {
        return intval($product_row['product_id']);
    }
}

function store_id_from_store_name($store_name)
{
    $link = mysqli_connect(DB_HOST, DB_USERNAME, DB_PASSWORD, DB_NAME);
    header("Cache-Control: no-cache,no-store");
    $sanitized_store_name = $link->escape_string($store_name);
    $store_query = "SELECT * FROM stores WHERE store_name=\"" . $sanitized_store_name . "\";";
    $store_result = $link->query($store_query)  or die("Error in the consult.." . mysqli_error($link));

    while ($store_row = $store_result->fetch_assoc())
    {
        return intval($store_row['store_id']);
    }

}

?>