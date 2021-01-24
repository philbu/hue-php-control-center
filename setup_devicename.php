<?php
$config = include_once "config.php";

if(isset($_POST["name"])) {
  $config->setDeviceName($_POST["name"]);
  header("Location: setup.php", TRUE, 307);
  exit;
}
?>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <style>
      body {
        text-align: center;
      }

      .button {
        font-size: 30px;
        background-color: #0381f0; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
      }
    </style>
  </head>
  <body>
    <h1>Enter the name of the device</h1>
    <p>(should be unique)</p>
    <form action="setup_devicename.php" method="post">
      <p>Enter the name of the server:</p>
      <input type="text" name="name" value="<?php echo gethostname();?>"/>
      <input class="button" type="submit" name="submit" value="Submit"/>
    </form>
  </body>
</html>