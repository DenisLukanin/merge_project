<?php
class Db {
    private $connection;
    private static $instance;
    const T_INT = "INT";
    const T_VARCHAR = "VARCHAR(255)";
    const T_NOT_NULL = "NOT NULL";
    const T_NULL = "NULL";
    const A_I = "AUTO_INCREMENT";
    const T_TEXTAREA = "TEXTAREA";
    const P_KEY = "PRIMARY KEY";

    public static function get_instance(): Db {
        if (self::$instance === NULL){

            self::$instance = new self();
        }
        return self::$instance;
    }

    private function __construct()
    {
        $this->connect();
    }

    private function connect() {
        $user = Config::get_config("db", "user");
        $password = Config::get_config("db", "password");
        $host = Config::get_config("db", "host");
        $db_name = Config::get_config("db", "name");
        $charset = Config::get_config("db", "charset");
        $this->connection = new PDO("mysql:host={$host};dbname={$db_name};charset={$charset}", $user, $password);
        
    }

    //Создание таблицы
    public function create_table(string $name, array $columns){  
        $request = "CREATE TABLE $name (".$this->create_columns($columns).");";
        $result = $this->connection->prepare($request);
        $result->execute();
    }

    private function create_columns(array $columns): string{
        $columns_request = [];
        $columns = array_map(fn ($item) => implode(" " , $item), $columns);
        foreach ($columns as $name => $value){
            $columns_request[] = $name." ".$value;
        }
        return implode(", " , $columns_request);
    }

    public function table_exists(string $table_name) : bool {
        $request = "SHOW TABLES LIKE '$table_name'";
        $statement = $this->connection->query($request);
        return $statement->fetch() == false ? false : true;
    }

    // запись в таблицу
    // пример запроса
    // "test5",[
    //     "age" => "27",
    // ]

    public function insert(string $name, array $value){
        $keys = implode(", ", array_keys($value));
        $keys_placeholder = implode(", ", array_map(fn ($item) => ":".$item, array_keys($value)) );
        $stm = $this->connection->prepare("insert into $name ($keys) value ($keys_placeholder)");
        foreach ($value as $name => $value1){
            $stm->bindValue($name , $value1);
        }
        $stm->execute();
        // aa( $this->connection->errorInfo());

        return $this->connection->lastInsertId();
    }

    public function select(string $table_name, string $where = "", $limit = 0) {
        $request = "SELECT * FROM $table_name";
        if($where != "") {
            $request .= " WHERE $where";
        }
        if($limit != 0) {
            $request .= " LIMIT $limit";
        }

        $result = $this->connection->prepare($request);
        $result->execute();
        
        return $result;
    }

    public function update($table_name, $id, array $new_value){
        $request = "
            UPDATE $table_name 
            SET ".$this->set_values($new_value)." 
            WHERE id = $id
        ";
        $state = $this->connection->prepare($request);
        return $state->execute();
    }

    private function set_values(array $values): string{
        $result = [];
        foreach ($values as $column => $value){
            $result[] = "$column = '$value'";
        }
        return implode(", " , $result);
    }
    
    function delete($table_name, $id){
        $sql = "
            DELETE
            FROM $table_name
            WHERE id = $id
        ";
        $stm = $this->connection->prepare($sql);
        return $stm->execute();
    }
    


    
    private function __clone(){
        throw new Exception("No clone", 1);
        
    }
    public function __wakeup(){
        throw new Exception("No unserialize", 1);
        
    }
}