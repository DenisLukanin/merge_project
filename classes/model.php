<?php
class Model {
    protected $table_name = "";
    protected $table_columns = [];                   
    protected $properties = [];                     
    protected $cache_table_names = [];
    protected $loaded = false;
    protected $table_elem_id;      
    protected $primary_key = "id";
    protected $db_object;   
    protected $properties_new = [];                  
    protected $module = "";
    protected $model = "";



    private function __construct($id = null){                                          
        $this->db_object = Db::get_instance();                                   
        $this->info();
        $this->check_table();
        if($id){
            $this->get($id);
        }        
    }

    private function info() {
        $class = get_class($this);
        $info = explode("\\", $class);
        foreach($info as $key => $elem) {
            if($elem == "Module") {
                $this->module = lcfirst($info[++$key]);
            }
            if($elem == "Model") {
                $this->model = lcfirst($info[++$key]);
            }

        }
    }

    public static function factory(array $info_about_model) {
        $module = "";
        $component = "";
        $id = "";

        if(!array_key_exists("name", $info_about_model)) {
            throw new Exception("name dont exists", 500);
        }

        $name = $info_about_model["name"];

        if(array_key_exists("module", $info_about_model)) {
            $module = $info_about_model["module"];
        }

        if(array_key_exists("id", $info_about_model)) {
            $id = $info_about_model["id"];
        }

        if(array_key_exists("component", $info_about_model)) {
            $component = $info_about_model["component"];
        }

        $namespace = "";
        if($module) {
            $namespace .= "Module\\$module";
        }
        if($component) {
            $namespace .= "\\$component";
        }

        $namespace .= "\Model\\$name";

        return new $namespace($id);
    }

    protected function check_table(){
        if(!in_array($this->table_name, $this->cache_table_names)){
            $this->cache_table_names[] = $this->table_name;
            if(!$this->db_object->table_exists($this->table_name)){
                echo "ok";
                $this->create_table($this->table_name, $this->table_columns);
            }
        }
    }

    public function create_table(){
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

    public function __get($name){
        if (in_array($name, array_keys($this->table_columns))) {    
            return  $this->properties[$name];                       
        }
        echo "$name - нет такой колонки<br>";
    }

    public function __set($name, $value){
        if (in_array($name, array_keys($this->table_columns))) {                                                
            if ($this->loaded && $this->properties[$name] != $value){
                $this->properties_new[$name] = $value;                                                          
            }
            $this->properties[$name] = $value;  
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

    public function delete($id){
        Cache::delete_cache($id);
        aa($this->db_object->delete($this->table_name,$id));
        return $this->db_object->delete($this->table_name,$id);
    }

    public function create_view_url() {
        return "/$this->module/view/create";
    }

    public function create_rest_url() {

        return "/$this->module/rest/$this->model/create/";
    }

    function get_form_fields(): array{
        $form = [];
        foreach($this->table_columns as $name_column => $setting_column){
            if ($setting_column["label"]) $form[$name_column] = $setting_column;
        }

        return $form;
    }


}