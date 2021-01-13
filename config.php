<?php
  class Config {
    public function isInitialized() {
      $output = parse_ini_file("config.ini", true);
      if ($output === false) {
        die("Missing config.ini!");
      }
      if ($output["bridge"]["address"] === "unknown") {
        return false;
      }
      if ($output["bridge"]["devicename"] === "unknown") {
        return false;
      }
      if ($output["bridge"]["username"] === "unknown") {
        return false;
      }
      return true;
    }

    function missing() {
      $output = parse_ini_file("config.ini", true);
      if ($output === false) {
        die("Missing config.ini!");
      }
      if ($output["bridge"]["address"] === "unknown") {
        return "address";
      }
      if ($output["bridge"]["devicename"] === "unknown") {
        return "devicename";
      }
      if ($output["bridge"]["username"] === "unknown") {
        return "username";
      }
      return "";
    }

    function reset() {
      # TODO write reset
    }

    function setIpAddress($ipAddress) {
      $this->set('bridge', 'address', $ipAddress);
    }

    function set($section, $key, $value) {
      $config_data = parse_ini_file("config.ini", true);
      $config_data[$section][$key] = $value;
      $new_content = '';
      foreach ($config_data as $section => $section_content) {
          $section_content = array_map(function($value, $key) {
              return "$key=$value";
          }, array_values($section_content), array_keys($section_content));
          $section_content = implode("\n", $section_content);
          $new_content .= "[$section]\n$section_content\n";
      }
      file_put_contents("config.ini", $new_content);
  }
  }
  $config = new Config();
  return $config;
?>
