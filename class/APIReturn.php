<?php


class APIReturn
{

    public static function makeJson ($success, $message) {

        echo json_encode(['success' => $success, 'result' => $message]);
        exit;

    }

}