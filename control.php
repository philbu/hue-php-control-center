<?php

function getLights($url) {
  $req = curl_init();
  curl_setopt_array($req, [
      CURLOPT_URL            => "$url/lights",
      CURLOPT_RETURNTRANSFER => true,
  ]);
  $response = curl_exec($req);
  curl_close($req);
  return json_decode($response);
}

function setLight($key, $url, $type, $value) {
  $req = curl_init();
  $data = array($type => $value);
  if ($type === 'on') {
    $data = array($type => boolval($value));
  }
  if ($type === 'bri' | $type === 'hue' | $type === 'sat') {
    $data = array($type => intval($value));
  }
  curl_setopt_array($req, [
      CURLOPT_URL            => "$url/lights/$key/state",
      CURLOPT_CUSTOMREQUEST  => "PUT",
      CURLOPT_POSTFIELDS     => json_encode($data),
      CURLOPT_HTTPHEADER     => [ "Content-Type" => "application/json" ],
      CURLOPT_RETURNTRANSFER => true,
  ]);
  $response = curl_exec($req);
  curl_close($req);
  echo "$response";
}

function printLight($key, $settings) {
  echo "<hr>";
  $state = $settings->state->on;
  $class = $state ? 'light-on' : 'light-off';
  # name
  $name = $settings->name;
  # productname
  $productname = $settings->productname;
  echo "<div class=\"$class\">";

  echo "<div>
    <h3>$name</h3>
    <p>$productname</p>
  </div>";
  # state
  if ($state) {
    echo "<form action=\"\" method=\"post\">
      <input class=\"button off\" type=\"submit\" name=\"text\" value=\"OFF\"/>
      <input class=\"hidden\" name=\"type\" value=\"on\"/>
      <input class=\"hidden\" name=\"value\" value=\"0\"/>
      <input class=\"hidden\" name=\"key\" value=\"$key\"/>
    </form>";
    echo "<div class=\"slider-list\">";
    if (isset($settings->state->bri)) {
      $bri = $settings->state->bri;
      echo "<h4>Brightness slider:</h4>
        <input class=\"slider\" type=\"range\"
          min=\"1\" max=\"254\" value=\"$bri\"
          onchange=\"updateSlider($key, 'bri', this.value)\">";
    }
    if (isset($settings->state->hue)) {
      $hue = $settings->state->hue;
      echo "<h4>Hue slider:</h4>
      <input class=\"slider\" type=\"range\"
        min=\"0\" max=\"65535\" value=\"$hue\"
        onchange=\"updateSlider($key, 'hue', this.value)\">";
    }
    if (isset($settings->state->sat)) {
      $sat = $settings->state->sat;
      echo "<h4>Saturation slider:</h4>
      <input class=\"slider\" type=\"range\"
        min=\"0\" max=\"254\" value=\"$sat\"
        onchange=\"updateSlider($key, 'sat', this.value)\">";
    }
    echo "</div>";
  } else {
    echo "<form action=\"\" method=\"post\">
      <input class=\"button\" type=\"submit\" name=\"text\" value=\"ON\"/>
      <input class=\"hidden\" name=\"type\" value=\"on\"/>
      <input class=\"hidden\" name=\"value\" value=\"1\"/>
      <input class=\"hidden\" name=\"key\" value=\"$key\"/>
    </form>";
  }

  echo "</div>";
}

function printLightControl($url) {
  $json = getLights($url);
  foreach ($json as $key => $value) {
    printLight($key, $value);
  }
}

function interpretPost($post, $url) {
  if (isset($post['key'])) {
    $key = $post['key'];
    if (isset($post['type'])) {
      $type = $post['type'];
      if (isset($post['value'])) {
        $value = $post['value'];
        setLight($key, $url, $type, $value);
      }
    }
  }
}
?>