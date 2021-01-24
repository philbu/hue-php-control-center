<html>
<?php
$config = include_once "config.php";

if (!$config->isInitialized()) {
  header("Location: setup.php", TRUE, 307);
  exit;
}
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

    .light-off {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: auto;
      align-items: center;
    }

    .light-on {
      display: grid;
      grid-template-columns: 1fr 1fr;
      grid-template-rows: auto auto;
      grid-template-areas: 
        "one two"
        "sliders sliders";
      align-items: center;
    }

    .hidden {
      display: none;
    }

    .slider-list {
      grid-area: sliders;
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
    function updateSlider(key, type, value) {
      var xhr = new XMLHttpRequest();
      xhr.open("POST", '', true);
      xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
      xhr.send('type='+type+'&value='+value+'&key='+key);
    }
  </script>
</head>
<body>
  <h1>Hue Control Center</h1>
<?php
include_once "control.php";

interpretPost($_POST, $config->getUrl());
printLightControl($config->getUrl());

?>
</body>
</html>
