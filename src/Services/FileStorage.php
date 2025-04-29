<?php 
namespace App\Services;

class FileStorage implements ILoadStorage, ISaveStorage
{
    public function loadData(string $name): ?array
    {       
        $handle = fopen($name, "r");
        $data = fread($handle, filesize($name)); 
        fclose($handle);

        $arr = json_decode($data, true); 
        
        return $arr; 
    }

    public function saveData(string $name, array $arr): bool
    {
        $handle = fopen($name, "r");
        if (filesize($name) > 0){ 
            $data = fread($handle, filesize($name)); 
            $allRecords = json_decode($data, true); 
        } else {
            $allRecords = [];
        }
        fclose($handle);
        
        $allRecords[]= $arr;
        $json = json_encode($allRecords, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

        $handle = fopen($name, "w");
        fwrite($handle, $json);
        fclose($handle);

        return true;
    }
}
