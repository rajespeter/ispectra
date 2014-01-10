<?php  
// This file is www.developphp.com curriculum material
// Written by Adam Khoury January 01, 2011
// http://www.youtube.com/view_play_list?p=442E340A42191003
/*  
1: "die()" will exit the script and show an error statement if something goes wrong with the "connect" or "select" functions. 
2: A "mysql_connect()" error usually means your username/password are wrong  
3: A "mysql_select_db()" error usually means the database does not exist. 
*/ 
// Place db host name. Sometimes "localhost" but  
// sometimes looks like this: >>      ???mysql??.someserver.net 

include "./PayPalCart/functions/constants_live.php"; 

// Run the actual connection here  
//mysql_connect("DB_SERVER","DB_USER","DB_PASS") or die ("could not connect to mysql");
//mysql_select_db("DB_NAME") or die ("no database");              

$mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME);

?>