<?php
$host = 'localhost';
$port = '5432';
$db = 'ProgettoTsw';
$user = 'postgres';
$password = '123';

$cn = "host=$host port=$port dbname=$db user=$user password=$password";
$db = pg_connect($cn) or die('Impossibile connetersi al database: ' . pg_last_error());
?>