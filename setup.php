<?php
  $config = include_once "config.php";

  if ($config->missing() === "address") {
    include "setup_address.php";
    exit;
  }
  if ($config->missing() === "devicename") {
    include "setup_devicename.php";
    exit;
  }
  if ($config->missing() === "username") {
    include "setup_username.php";
    exit;
  } 
?>
