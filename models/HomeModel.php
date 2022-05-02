<?php 
class HomeModel extends Model
{

    public function sayHello()
    {
        echo "HomeModel say hello!";
    } 

    public function thisisjustarrays() 
    {
        return [
            "name" => "Alisher",
            "surname" => "Smagulov",
            "age" => 19,
            "city" => "Semey"
        ];
    }

    public function sayDsn()
    {
        print_r(static::all("posts"));
    }

    public function takeId()
    {
        return static::all("posts");
    }
}