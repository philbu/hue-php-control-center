<?php
  class Config {
    public $output = false;

    function __construct() {
      $this->initialize();
    }

    private function initialize() {
      $this->output = parse_ini_file("config.ini", true);
      if ($this->output === false) {
        die("Missing config.ini!");
      }
    }

    public function isInitialized() {
      if ($this->output["bridge"]["address"] === "unknown") {
        return false;
      }
      if ($this->output["bridge"]["devicename"] === "unknown") {
        return false;
      }
      if ($this->output["bridge"]["username"] === "unknown") {
        return false;
      }
      return true;
    }

    public function missing() {
      if ($this->output["bridge"]["address"] === "unknown") {
        return "address";
      }
      if ($this->output["bridge"]["devicename"] === "unknown") {
        return "devicename";
      }
      if ($this->output["bridge"]["username"] === "unknown") {
        return "username";
      }
      return "";
    }

    function reset() {
      # TODO write reset
    }

    public function getIpAddress() {
      return $this->output['bridge']['address'];
    }

    public function setIpAddress($ipAddress) {
      $this->set('bridge', 'address', $ipAddress);
    }

    public function setDeviceName($name) {
      $this->set('bridge', 'devicename', $name);
    }

    public function getDeviceType() {
      return $this->output['bridge']['devicetype'] . $this->output['bridge']['devicename'];
    }

    public function setUsername($username) {
      $this->set('bridge', 'username', $username);
    }

    public function getUrl() {
      #http://<address>/api/<username>/
      return "http://"
        . $this->output['bridge']['address']
        . "/api/"
        . $this->output['bridge']['username'];
    }

    private function set($section, $key, $value) {
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
      $this->output = parse_ini_file("config.ini", true);
    }
  }
  $config = new Config();
  return $config;
?>
