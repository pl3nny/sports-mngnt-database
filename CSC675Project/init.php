<?php
// ob_start();
// ini_set('session.cookie_httponly', true);
// session_start();
// session_cache_limiter();


$host="localhost"; //localhost
$username="root"; //database username
$password="root"; //password for user to database
$db_name="csc675_project"; //name of database

//opens connection to mysql server

$dbc= mysqli_connect("$host","$username", "$password" );
if(!$dbc)
{
    die("Couldn't connect to the MySQL server");
}

//select database
$db_selected = mysqli_select_db($dbc, "$db_name");
if(!$db_selected)
{
   die("Couldn't connect to the database");
}