<?php

defined('DB_SERVER') ? null : define("DB_SERVER", "localhost");
defined('DB_USER') ? null : define("DB_USER", "mynetglo_builder");
defined('DB_PASS') ? null : define("DB_PASS", "12dml,47Az2");
defined('DB_NAME') ? null : define("DB_NAME", "mynetglo_mystore");

// Run the actual connection here  
//mysql_connect("DB_SERVER","DB_USER","DB_PASS") or die ("could not connect to mysql");
//mysql_select_db("DB_NAME") or die ("no database");    

echo DB_SERVER;

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);



$result = $mysqli->query("SELECT * FROM products");
//$result = $mysql_query("SELECT * FROM products");
    
    if ($result->num_rows > 0)
    {
        $row_num = 0;
        while ($row = $result->fetch_object())
        {
            //$products[$row_num]['id'] = $row->id;
            $products[$row_num]['id'] = $row->product_name;
            $products[$row_num]['price'] = number_format($row->price, 2);
            $products[$row_num]['details'] = $row->details;
            $products[$row_num]['category'] = $row->category;
            $products[$row_num]['subcategory'] = $row->subcategory;
            $products[$row_num]['date_added'] = $row->date_added;
            $row_num++;
        }
        echo "<pre>";
        print_r($products);
        echo "</pre>";
    }
    else
    {
        return FALSE;
    }


?>