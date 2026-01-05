<?php

$localhost	= "localhost";
$username	= "root";
$password	= "";
$dbname		= "sbd_25sa11a027";

$con = new mysqli($localhost, $username, $password, $dbname);

if($con->connect_error) {
	die("Gagal Koneksi : " . $conn->connect_error);
}
