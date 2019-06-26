<?php


class Pizza
{

    public static function add () {

        if (empty(RequestReader::$requestJsonValue['sabor']) || empty(RequestReader::$requestJsonValue['tamanho'])) {

            APIReturn::makeJson(false, 'Nao foi informado o sabor e tamanho');

        }

        self::validaTamanho();

        $currentOperation = PDOConnect::$DB->prepare
        (

            'INSERT INTO tb_pizza (sabor, tamanho) VALUES (:sabor, :tamanho)'

        );

        $currentOperation->bindValue(':sabor', RequestReader::$requestJsonValue['sabor']);
        $currentOperation->bindValue(':tamanho', RequestReader::$requestJsonValue['tamanho']);

        $currentOperation->execute();

        APIReturn::makeJson(true, 'Pizza inserida com sucesso.');

    }

    public static function edit () {

        if (
            empty(RequestReader::$requestJsonValue['saborPesquisa']) ||
            empty(RequestReader::$requestJsonValue['tamanhoPesquisa']) ||
            empty(RequestReader::$requestJsonValue['sabor']) ||
            empty(RequestReader::$requestJsonValue['tamanho'])
        ) {

            APIReturn::makeJson(false, 'Há dados nao informados');

        }

        self::validaTamanho();

        $currentOperation = PDOConnect::$DB->prepare
        (

            'UPDATE `tb_pizza` SET sabor = :sabor,tamanho = :tamanho WHERE sabor = :saborPesquisa AND tamanho = :tamanhoPesquisa'

        );

        $currentOperation->bindValue(':sabor', RequestReader::$requestJsonValue['sabor']);
        $currentOperation->bindValue(':tamanho', RequestReader::$requestJsonValue['tamanho']);
        $currentOperation->bindValue(':saborPesquisa', RequestReader::$requestJsonValue['saborPesquisa']);
        $currentOperation->bindValue(':tamanhoPesquisa', RequestReader::$requestJsonValue['tamanhoPesquisa']);

        $currentOperation->execute();

        APIReturn::makeJson(true, 'Pizza atualizada com sucesso.');


    }

    public static function select () {

        $whereConditions = '';
        $whereBind = [];

        if (!empty(RequestReader::$requestJsonValue['tamanho'])) {

            $whereConditions .= ' WHERE tamanho = :tamanho ';
            $whereBind[] = [':tamanho', RequestReader::$requestJsonValue['tamanho']];

        }

        if (!empty(RequestReader::$requestJsonValue['sabor'])) {

            $whereConditions .=
                empty($whereConditions)
                    ? ' WHERE sabor = :sabor '
                    : ' AND sabor = :sabor ';

            $whereBind[] = [':sabor', RequestReader::$requestJsonValue['sabor']];

        }

        $currentOperation = PDOConnect::$DB->prepare
        (

            'SELECT id, tamanho, sabor FROM tb_pizza ' . $whereConditions . ' ORDER BY sabor'

        );

        foreach ($whereBind as $currentBind) {

            $currentOperation->bindValue($currentBind['0'], $currentBind['1']);

        }

        $currentOperation->execute();

        APIReturn::makeJson(true, $currentOperation->fetchAll(PDO::FETCH_ASSOC));

    }

    public static function delete () {


        if (
            empty(RequestReader::$requestJsonValue['sabor']) ||
            empty(RequestReader::$requestJsonValue['tamanho'])
        ) {

            APIReturn::makeJson(false, 'Nao foi informado o sabor e tamanho');

        }

        $currentOperation = PDOConnect::$DB->prepare
        (

            'DELETE FROM tb_pizza WHERE tamanho = :tamanho AND sabor = :sabor'

        );

        $currentOperation->bindValue(':sabor', RequestReader::$requestJsonValue['sabor']);
        $currentOperation->bindValue(':tamanho', RequestReader::$requestJsonValue['tamanho']);

        $currentOperation->execute();

        APIReturn::makeJson(true, 'Pizza apagada com sucesso.');

    }

    private static function validaTamanho () {

        if (
            RequestReader::$requestJsonValue['tamanho'] != 'P' &&
            RequestReader::$requestJsonValue['tamanho'] != 'M' &&
            RequestReader::$requestJsonValue['tamanho'] != 'G'
        ) {

            APIReturn::makeJson(false, 'O tamanho informado é invalido. (apenas P,M ou G).');

        }

    }

}