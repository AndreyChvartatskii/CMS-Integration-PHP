<?php
class curl {
  public $token;
  public $api_url;

  public function __construct($token, $api_url) {
    $this->token = $token;
    $this->api_url = $api_url;
  }


  public function request($method, $entity, $headers = [], $data = null) {
    $headers = array_merge([ 'Authorization: Bearer '.$this->token, 'Accept-Encoding: gzip' ], $headers);
    $headers_str = '';
    foreach ($headers as $header) $headers_str .= ' -H "'.$header.'"';
    $data_str = isset($data) ? " -d '".$data."'" : '';
    
    $command = "curl -X $method \"$this->api_url/$entity\" $headers_str $data_str --compressed";
    
    return shell_exec($command);
  }
}
