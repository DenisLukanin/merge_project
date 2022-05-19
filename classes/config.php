<?
class Config {
    private static $config_cache = [];

    public static function get_config(string $config_name, string $config_key = "") {
        $config = self::include_config($config_name);

        if($config != null) {
            if($config_key == "") {
                return $config;
            }
            else
            {
                if(array_key_exists($config_key, $config)) {
                    return $config[$config_key];
                }
                else {
                    return null;
                }
            }
        }
        else
        {
            return null;
        }

    }

    private static function include_config(string $config_name) {
        if(array_key_exists($config_name, self::$config_cache)) {
            //echo "cache ";
            return self::$config_cache[$config_name];
        }
        else
        {
            $path = $_SERVER["DOCUMENT_ROOT"] . DIRECTORY_SEPARATOR . "configs" . DIRECTORY_SEPARATOR . $config_name . ".php";
            if(file_exists($path)) {
                self::$config_cache[$config_name] = include_once($path);
                return self::$config_cache[$config_name];
            }
            else
            {   
                return null;
            }
        }
    }
}