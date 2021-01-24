<?php

function getUsername() {
  $config = new Config();
  $data = array("devicetype" => $config->getDeviceType());
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
      CURLOPT_CUSTOMREQUEST  => "POST",
      CURLOPT_POSTFIELDS     => json_encode($data),
      CURLOPT_HTTPHEADER     => [ "Content-Type" => "application/json" ],
  );
  $ch = curl_init("http://".$config->getIpAddress()."/api");
  curl_setopt_array($ch, $options);
  $response = curl_exec($ch);
  curl_close($ch);
  $json = json_decode($response);
  if (isset($json[0])) {
    $json = $json[0];
  }
  if (isset($json->success)) {
    if (isset($json->success->username)) {
      $config->setUsername($json->success->username);
      header("Location: index.php", TRUE, 307);
      exit;
    }
  }
  if (isset($json->error)) {
    if (isset($json->error->description)) {
      echo "Error: " . $json->error->description;
    }
  }
}

getUsername();

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
    <h1>Push the button on the bridge</h1>
    <p>and refresh</p>
    <form>
      <input class="button" type="submit" name="submit" value="Refresh"/>
    </form>
  </body>
</html>