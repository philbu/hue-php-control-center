<html>
<?php
/*$config = include_once "config.php";

if (!$config->isInitialized()) {
  header("Location: /setup.php", TRUE, 307);
  exit;
}*/
?>
<head>
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <style>
    body {
      text-align: center;
    }

    .button {
      font-size: 30px;
      background-color: #4CAF50; /* Green */
      border: none;
      color: white;
      padding: 15px 32px;
      text-align: center;
      text-decoration: none;
      display: inline-block;
    }

    .off {
      background-color: #ff443d!important;
    }

    .slider {
      -webkit-appearance: none;
      width: 80%;
      height: 15px;
      border-radius: 5px;
      background: #d3d3d3;
      outline: none;
      -webkit-transition: .2s;
      transition: opacity .2s;
    }

    .slider::-webkit-slider-thumb {
      -webkit-appearance: none;
      appearance: none;
      width: 25px;
      height: 25px;
      border-radius: 50%;
      background: #4CAF50;
      cursor: pointer;
    }

    .slider::-moz-range-thumb {
      width: 25px;
      height: 25px;
      border-radius: 50%;
      background: #4CAF50;
      cursor: pointer;
    }
  </style>
  <script>
    function updateSlider(brightness) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", '', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send('brightness='+brightness);
    }
  </script>
</head>
<body>
<?php

$brightness = 0;

function isOn() {
  global $brightness;
  $req = curl_init();
  curl_setopt_array($req, [
      CURLOPT_URL            => "http://192.168.178.32/api/Ke9p6oevMDBPL1JXZ27ZgccBvtVCka8D2cXHujKU/lights/3",
      CURLOPT_RETURNTRANSFER => true,
  ]);

  $string_response = curl_exec($req);
  $response = json_decode($string_response, true);
  $brightness = $response["state"]["bri"];
  if($response["state"]["on"]){
    return true;
  }
  return false;
}


function turnOn($bool) {
  $req = curl_init();
  $data = array("on" => $bool);
  curl_setopt_array($req, [
      CURLOPT_URL            => "http://192.168.178.32/api/Ke9p6oevMDBPL1JXZ27ZgccBvtVCka8D2cXHujKU/lights/3/state",
      CURLOPT_CUSTOMREQUEST  => "PUT",
      CURLOPT_POSTFIELDS     => json_encode($data),
      CURLOPT_HTTPHEADER     => [ "Content-Type" => "application/json" ],
      CURLOPT_RETURNTRANSFER => true,
  ]);

  $response = curl_exec($req);
}

function setBrightness($bri) {
  $req = curl_init();
  $data = array("bri" => $bri);
  curl_setopt_array($req, [
      CURLOPT_URL            => "http://192.168.178.32/api/Ke9p6oevMDBPL1JXZ27ZgccBvtVCka8D2cXHujKU/lights/3/state",
      CURLOPT_CUSTOMREQUEST  => "PUT",
      CURLOPT_POSTFIELDS     => json_encode($data, JSON_NUMERIC_CHECK),
      CURLOPT_HTTPHEADER     => [ "Content-Type" => "application/json" ],
      CURLOPT_RETURNTRANSFER => true,
  ]);

  $response = curl_exec($req);
}

if(isset($_POST["turnlights"])) {
  if($_POST["turnlights"] === "On") {
    turnOn(true);
  } else if ($_POST["turnlights"] === "Off") {
    turnOn(false);
  }
}
if(isset($_POST["brightness"])) {
  setBrightness($_POST["brightness"]);
}

if (isOn()) {
  echo "<form action=\"\" method=\"post\">
  <input class=\"button off\" type=\"submit\" name=\"turnlights\" value=\"Off\"/>
  <h2>Brightness slider:</h2>
  <input class=\"slider\" type=\"range\" min=\"1\" max=\"254\" value=\"$brightness\" onchange=\"updateSlider(this.value)\">
  </form>";
} else {
  echo '<form action="" method="post">
  <input class="button" type="submit" name="turnlights" value="On"/>
  </form>';
}
?>
</body>
</html>
