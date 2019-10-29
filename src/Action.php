<?php

namespace Cachelot;

class Action implements ClientInterface
{
    protected $server;
    
    public function __construct($host = "localhost",$port = 3000){
        $this->server = stream_socket_client("tcp://$host:$port", $errno, $errstr, 30);
        if (!$this->server){
            throw new Exception('Server not found');
        }
    }
    
    public function __destruct(){
        $this->close();
    }
    
    public function close(): void{
        fclose($this->server);
    }

    private function query($value){        
        $size = mb_strlen($value)+1; 
        $size += mb_strlen($size);
        if(preg_match("/\d*([0])/", $size)){
            $size++;
        }
        fwrite($this->server, $size." ".$value);
        
        $output = "";
        $size = 1024;
        $sizeRead = 0;
        $maxPacket = 0;
        
        while (true){
            $output .= fread($this->server, $size);
            
            if ($output == "OK" || $output == "undefined"){
                break;
            }
            
            if ($sizeRead == 0){
                preg_match("/^(\d+)\s*(.*)/", $output, $result);
                if (!empty($result[0])){
                    $maxPacket = $result[1];
                    $output = substr($output, mb_strlen($result[1])+1);
                } else {
                    return "Error";
                }
            }
            
            $sizeRead += $size;
            if ($maxPacket <= $sizeRead){
                break;
            }
        }
        
        return $output;
    }

    public function get($key){
        $result = $this->query("get $key");
        if ($this->isJson($result)){
            $result = json_decode($result);
        }
        
        return $result;
    }

    public function set($key, $val): string{
        if (is_array($val)){
            $val = json_encode($val);
        }
        
        return $this->query("set $key=$val");
    }
    
    public function show(): string{
        return $this->query("show");
    }
    
    public function del($key): string{
        return $this->query("del $key");
    }
    
    public function die($key, $timeout): string{
        return $this->query("die $key=$timeout");
    }
    
    private function isJson($string) {
        json_decode($string);        
        return (json_last_error() == JSON_ERROR_NONE);
    }
}