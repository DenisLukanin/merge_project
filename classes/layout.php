<?php 
class Layout
{

    private static $instance;
    private static $static_type = [
        "style" => [
            "css",
        ],
        "script" => [
            "js",
        ],
    ];

	// массивы со статикой
    private static $list_static = [
        "style" => [],
        "script" => [],
        "fonts" => [],

    ];

    private static $static_relative_path = DIRECTORY_SEPARATOR. "static".DIRECTORY_SEPARATOR;
	private static function static_absolute_path() {
        return $_SERVER['DOCUMENT_ROOT'] . DIRECTORY_SEPARATOR. "static".DIRECTORY_SEPARATOR;
    }








    // Логика создания экземпляра класса*******
    private function __construct(){
        $this->set_static("general/reset.css");
        self::set_fonts(Config::get_config('layout', 'font') ?? 'Cormorant Garamond');
        $this->set_static("general/bootstrap.css");
    }

    public static function get_instance(): Layout {
        if (self::$instance === null){
            self::$instance = new self();
        }
        
        return self::$instance;
    }





    // логика подключения статики******
    

    function get_static_style(){
        foreach(array_unique(self::$list_static['style']) as $link){
            echo '<link rel="stylesheet" href="'.$link.'">';

        };
        foreach(self::$list_static['fonts'] as $link){
            echo $link;
        };
    }
    function get_static_script(){
        foreach(array_unique(self::$list_static['script']) as $script){
            echo '<script src="'.$script.'"></script>';
        };
    }
    function get_static(){
        $this->get_static_style();
        $this->get_static_script();
    }



    public function set_statics(array $paths){
        foreach($paths as $path){
            $this->set_static($path);
        }
    }
    // определяем скрипт это или стиль
    public function set_static($path){
        $path_info = pathinfo($path);  
        foreach(self::$static_type as $type => $extension){
            if (in_array($path_info['extension'], $extension)){
                if(file_exists(self::static_absolute_path().$path_info['extension']."/".$path)){
                    self::$list_static[$type][] = self::$static_relative_path.$path_info['extension']."/".$path;
                } else {
                    // echo 'такого файла нет<br>'; 
                }
            }
        }

    }






    // подключение шрифта google fonts***********
    private static function set_fonts(string $font_name){
        $font_name_plas = str_replace(" ", "+", trim($font_name));
        self::$list_static["fonts"][$font_name] = '
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family='.$font_name_plas.':wght@400;600&display=swap" rel="stylesheet">
        
        <style>
            :root{
                --font: "'.$font_name.'" , sans-serif;
            }
        </style>
        ';
    }


        

    // защита от создания копий объекта*********
    private function __clone()
    {
        throw new Exception("No clone", 1);
    }
    private function __wakeup()
    {
        throw new Exception("No unserialize", 1);
    }
}

?>