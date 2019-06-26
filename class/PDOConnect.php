<?php


class PDOConnect
{

    public static $DB;
    private $DBName = 'pizzaria';
    private $DBHost = '127.0.0.1';
    private $DBUser = 'root';
    private $DBPass = '';


    public function __construct()
    {

        if (!self::$DB) {

            self::$DB = new PDO
            (
                'mysql:dbname='.$this->DBName.';host='.$this->DBHost,
                $this->DBUser,
                $this->DBPass
            );

        }

    }

}