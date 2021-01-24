<?php
$config = include_once "config.php";

function testAddress($ipAddress) {
  $options = array(
      CURLOPT_RETURNTRANSFER => true,   // return web page
      CURLOPT_HEADER         => false,  // don't return headers
      CURLOPT_FOLLOWLOCATION => true,   // follow redirects
      CURLOPT_MAXREDIRS      => 10,     // stop after 10 redirects
      CURLOPT_ENCODING       => "",     // handle compressed
      CURLOPT_USERAGENT      => "scanningforhue", // name of client
      CURLOPT_AUTOREFERER    => true,   // set referrer on redirect
      CURLOPT_CONNECTTIMEOUT => 1,    // time-out on connect
      CURLOPT_TIMEOUT        => 120,    // time-out on response
  );
  $ch = curl_init("http://$ipAddress/");
  curl_setopt_array($ch, $options);
  $response = curl_exec($ch);
  curl_close($ch);
  return strpos($response, "<title>hue personal wireless lighting</title>") !== false;
}

function scanNetwork() {
  # this can go wrong
  $localIP = $_SERVER['SERVER_ADDR'];
  $ipParts = explode(".", $localIP);
  # skip .0 address
  for ($i = 1; $i < 256; $i++) {
    $isHueAddress = testAddress("$ipParts[0].$ipParts[1].$ipParts[2].$i");
    if ($isHueAddress) {
      return "$ipParts[0].$ipParts[1].$ipParts[2].$i";
    }
  }
}

if(isset($_POST["scan"])) {
  $config->setIpAddress(scanNetwork());
  header("Location: setup.php", TRUE, 307);
  exit;
}

if(isset($_POST["address"])) {
  $isHueAddress = testAddress($_POST["address"]);
  if ($isHueAddress) {
    $config->setIpAddress($_POST["address"]);
    header("Location: setup.php", TRUE, 307);
    exit;
  }
  echo "Wrong address!";
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
    <h1>Enter or find the IP address of the Hue Bridge</h1>
    <form action="setup_address.php" method="post">
      <p>Enter the IP address of the bridge:</p>
      <input type="text" name="address"/>
      <input class="button" type="submit" name="submit" value="Submit"/>
    </form>
    <h2>OR</h2>
    <form action="setup_address.php" method="post">
      <input class="button" type="submit" name="scan" value="Scan"/>
    </form>
    <p>Scanning may take a while.</p>
  </body>
</html>