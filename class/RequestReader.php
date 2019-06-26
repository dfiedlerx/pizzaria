<?php


class RequestReader
{

    public static $requestJsonValue;

    public function __construct($jsonRequestName)
    {

        if (!empty($_POST[$jsonRequestName]) && $this->validJson($_POST[$jsonRequestName])) {

            self::$requestJsonValue = json_decode($_POST[$jsonRequestName], true);

        } else {

            APIReturn::makeJson(false, 'Nao foi passado um json valido ou com nome correto.');

        }

    }

    private function validJson ($suspect) {

        json_decode($suspect);
        return (json_last_error() == JSON_ERROR_NONE);

    }

}