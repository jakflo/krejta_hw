<?php
namespace Config;

class Loader
{
    private \stdClass $json;
    
    public function __construct(string $jsonName)
    {
        $file = file_get_contents(__DIR__."/{$jsonName}.json");
        if (!$file) {
            throw new \Exception('Config file not found');
        }
        
        $this->json = json_decode($file);
    }
    
    public function getProp(string $propName)
    {
        if (!isset($this->json->$propName)) {
            throw new \Exception("Json property {$propName} not found");
        }
        
        return $this->json->$propName;
    }
    
}
