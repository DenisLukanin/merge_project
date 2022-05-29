<?php
class Model {
    protected $table_name = "";
    protected $table_columns = [];                   // описание колонок таблицы
    protected $properties = [];                      // значения полей модели

    protected $cache_table_names = [];
    protected $loaded = false;
    protected $table_elem_id;                        // id текущей модели 


    protected $primary_key = "id";
    protected $db_object;                            // объект ДБ

    protected $properties_new = [];                  // новые значения которые ждут добавления





    protected $module = "";
    protected $model = "";


    public function __construct($id = null){                                          //получит namespace класса
        $this->db_object = Db::get_instance();                                      // инициализируем объект бд
        $this->check_table();
        if($id){
            $this->get($id);
        }        
    }

    protected function check_table(){
        // echo "ok";
        if(!in_array($this->table_name, $this->cache_table_names)){
            $this->cache_table_names[] = $this->table_name;
            if(!$this->db_object->table_exists($this->table_name)){
                echo "ok";
                $this->create_table($this->table_name, $this->table_columns);
            }
        }
    }
    // создание таблицы
    public function create_table(){
        // echo __METHOD__."<br>";
        $result = [];
        foreach($this->table_columns as $name => $type){
            if ($name == $this->primary_key){
                $type["type"] .= " ".Db::A_I;
                $type["type"] .= " ".Db::P_KEY;
            }
            if (is_string($type)){
                $this->table_columns[$this->primary_key] = [$type];
            }
            foreach($type as $system => $value){
                if ($system == "type" || $system == "null_default") {
                    $result[$name][] = $value;
                }
            }
            
        }
        $this->db_object->create_table($this->table_name, $result);
    }

    public function save() {
        $this->loaded ? $this->update() : $this->create();
        
    }
    protected function update(){
        
        Cache::delete_cache($this->table_elem_id);
        $this->db_object->update($this->table_name, $this->table_elem_id, $this->properties_new);     

    }
    protected function create(){
        aa($this->properties);
        $this->table_elem_id = Db::get_instance()->insert($this->table_name, $this->properties);
        
        $this->loaded = true;
    }
    protected function get($id){
        $cache_data = Cache::caching($id);
        if ($cache_data){
            $this->properties = $cache_data;
        } else {
            $statement = Db::get_instance()->select($this->table_name, "id = {$id}", 1);
            $row = $statement->fetch(PDO::FETCH_ASSOC);
            if($row) {
                $this->set($row);
            }
            Cache::caching($id, $row);
        }
        
    }
    public function set($properties) {
        foreach($properties as $name => $value) {
            $this->$name = $value;
        }
    }

    // показывает значение колонки
    public function __get($name){
        if (in_array($name, array_keys($this->table_columns))) {    // определена ли такая колонка в таблице
            return  $this->properties[$name];                       // возвращается значение 
        }
        echo "$name - нет такой колонки<br>";
        // return false;
    }


    // устанавливает новое значение колонки 
    public function __set($name, $value){
        if (in_array($name, array_keys($this->table_columns))) {                                                // определена ли такая колонка в таблице
            if ($this->loaded && $this->properties[$name] != $value){                                    // проверка определен ли id для модели, отличается ли значение от существующего
                                                                                                                // - имеет ли таблица статус новой   
                
                $this->properties_new[$name] = $value;                                                          // записываем новое значение в массив для update
            }
            $this->properties[$name] = $value;                                                                  // записываем новое значение в properties
            
        } else {
            echo "$name   - нет такой колонки запись невозможна<br>";
        }
    }

    public function get_json(){
        return json_encode($this->properties, JSON_UNESCAPED_UNICODE);
    }

    public function find_all($where = "", $limit = 0) {
        $statement = Db::get_instance()->select($this->table_name, $where, $limit);

        while($row = $statement->fetch())
        {
            $models[] = new $this($row["id"]);
            Cache::caching($row["id"], $row);
        }

        return $models;
    }

    public function find($where = "") {
        $statement = Db::get_instance()->select($this->table_name, $where, 1);
        $row = $statement->fetch();
        $models = [];
        $models[] = new $this($row["id"]);
        Cache::caching($row["id"], $row);
        return $models;
    }

    // удаление записи
    public function delete($id){
        Cache::delete_cache($id);
        aa($this->db_object->delete($this->table_name,$id));
        return $this->db_object->delete($this->table_name,$id);
    }

}