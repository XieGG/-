<?php
namespace BaseBundle\Service;

class AccessDbService 
{
    private $appRoot;
    
    public function __construct($appRoot)
    {
        $this->appRoot = $appRoot;
    }
    /**
     * access db
     * 
     * @param unknown $dbFile
     * @return number[]|string[]|\PDO[]|number[]|string[]
     */
    public function connection($dbFile)
    {
        try{
            dump(file_exists($this->appRoot . $dbFile));
            dump($this->appRoot . $dbFile);
            //$filePath = str_replace('/', '\\\\', $this->appRoot . $dbFile);
            $filePath = $this->appRoot . $dbFile;
            dump($filePath);
            $db = new \PDO("odbc:Driver={Microsoft Access Driver (*.mdb)};Dbq=".$filePath);
            return [
                'code' => 1,
                'msg' => '连接成功',
                'data' => $db
            ];
        } catch (\Exception $e) {
            return [
                'code' => 0,
                'msg' => $e->getCode() . ':' . $e->getMessage(),
                'data' => ''
            ];
        }
    }
}