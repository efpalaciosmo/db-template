<?php

Class Connection
{
    // Info needed for db
    private $host;
    private $dbname;
    private $user;
    private $password;
    private $connection;

    function __construct(){
        // Call the method connectionData, this return one array
        $data_list = $this->connectionData();
        $this->host = $data_list['host'];
        $this->user = $data_list['user'];
        $this->password = $data_list['password'];
        $this->dbname = $data_list['database'];

        try {
            $this->connection = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->password);
            // set the PDO error mode to exception
            $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            echo "Successfully connection";
            echo PHP_EOL;
        }catch (PDOException $e){
            // Capture the log on case of error
            $msg = "Database Error: ";
            $msg = $msg . $e->getMessage();
            echo $msg;
        }
    }

    // This method return a json, his fields are the data
    // storage on config.json
    private function connectionData(){
        $dir_name = dirname(__FILE__);
        $dir_conf = $dir_name . "/" . "tsconfig.json";
        $json_data = file_get_contents($dir_conf);
        return json_decode($json_data, true);
    }

    // This method set the data on UTF-8
    private function setUTF8($array){
        array_walk_recursive($array, function (&$item, $key){
            if(!mb_detect_encoding($item, 'utf-8', true)){
                $item = utf8_encode($item);
            }
        });
        return $array;
    }

    // Method to create a row, this method depend on each application
    public function createRow(){
        // TODO
    }

    // Method to read data
    public function readData($tbName){
        $query = "SELECT * FROM " . $tbName;
        $statement = $this->connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to update one row, this method depend on each application
    public function updateData($tbName, $id){
        $data = $this->readData($tbName);
        foreach ($data as $row){
            if($row['id']==$id){
                $query = "UPDATE ...";
                $statement = $this->connection->prepare($query);
                $statement->execute();
            }
        }
        return $statement->fetchAll(PDO::FETCH_ASSOC);
    }

    // Method to delete one row
    public function deleteData($dbName, $id){
        $query = "DELETE FROM ". $dbName . " WHERE id =" . $id;
        $statement = $this->connection->prepare($query);
        $statement->execute();
    }
}