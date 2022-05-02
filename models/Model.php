<?php
class Model 
{
    protected static $db;

    public function __construct()
    {
        static::$db = new PDO($this->getDsn(), $this->getUserName(), $this->getUserPass(), $this->getOptions());
    }

    public function __destruct()
    {
        static::$db = null;
    }

    private function getHost() 
    {
        return $_ENV["HOST"];
    }

    private function getDbName()
    {
        return $_ENV["DB_NAME"];
    }

    private function getUserName()
    {
        return $_ENV["USERNAME"];
    }

    private function getUserPass()
    {
        return $_ENV["USERPASS"];
    }

    private function getOptions()
    {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    private static function convertValues(array $values)
    {
        foreach($values as $k => &$v) {
            if(is_null($v)) {
                $v = "null";
            } else {
                $v = trim($v);
                $v = "'{$v}'";
            }
        }
        return $values;
    }

    private static function convertColumnsAndValues(array $columnsAndValues)
    {
        $string = null;
        foreach($columnsAndValues as $k => $v) {
            if($k !== array_key_last($columnsAndValues)) {
                $string .= "`{$k}` = '{$v}', ";

            } else {
                $string .= "`{$k}` = '{$v}'";
            }
        }
        return $string;
    }

    protected function getDsn()
    {
        return "mysql:host=". $this->getHost() .";dbname=". $this->getDbName();
    }
    // READ
    protected static function all(string $table)
    {
        return static::$db->query("SELECT * FROM `{$table}`")->fetchAll();
    }
    // READ
    protected static function where(string $table, string $something, string $column, $value)
    {
        return static::$db->query("SELECT {$something} FROM `{$table}` WHERE {$column} = {$value}")->fetchAll();
    }
    // READ
    protected static function like(string $table, string $where, $value)
    {
        return static::$db->query("SELECT * FROM `$table` WHERE `$where` LIKE '%$value%'")->fetchAll();
    }
    // CREATE
    protected static function insert(string $table, array $columns, array $values)
    {
        $columns = "`" . implode("`, `",$columns) . "`";
        $values = implode(",",static::convertValues($values));
        $query = "INSERT INTO `{$table}`({$columns}) VALUES ({$values})";
        
        return static::$db->query($query);
    }
    // UPDATE
    protected static function update(string $table, array $columnsAndValues, string $where, $value)
    {
        $string = static::convertColumnsAndValues($columnsAndValues);
        $query = "UPDATE `{$table}` SET {$string} WHERE `{$where}` = '{$value}'";
        
        return static::$db->query($query);
    }
    // DELETE
    protected static function delete(string $table,string $where, $value)
    {
        $query = "DELETE FROM `{$table}` WHERE {$where} = {$value}";
        return static::$db->query($query);
    }
}