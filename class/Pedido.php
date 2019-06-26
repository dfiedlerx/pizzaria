<?php


class Pedido
{

    public static function add () {

        if (
            empty(RequestReader::$requestJsonValue['pizzaId']) ||
            empty(RequestReader::$requestJsonValue['telefone']) ||
            empty(RequestReader::$requestJsonValue['nome']) ||
            empty(RequestReader::$requestJsonValue['endereco'])
        ) {

            APIReturn::makeJson(false, 'É obrigatoria a informação de idPizza, telefone e nome do cliente');

        }

        $currentOperation = PDOConnect::$DB->prepare
        (

            'INSERT INTO tb_pedido (pizza_id, telefone, nome, endereco) VALUES (:pizzaId, :telefone, :nome, :endereco)'

        );

        $currentOperation->bindValue(':pizzaId', RequestReader::$requestJsonValue['pizzaId']);
        $currentOperation->bindValue(':telefone', RequestReader::$requestJsonValue['telefone']);
        $currentOperation->bindValue(':nome', RequestReader::$requestJsonValue['nome']);
        $currentOperation->bindValue(':endereco', RequestReader::$requestJsonValue['endereco']);

        $currentOperation->execute();

        APIReturn::makeJson(true, 'Pedido inserido com sucesso.');

    }

    /*
    Foi especificado no enunciado o controle baseado no telefone,
    portanto nao haverá filtros personalizados com na classe Pizza.
    O unico filtro a mais que coloquei foi verificando se o pedido ja foi entregue ou nao
    Nao criei uma tabela tb_cliente separada da pedido pois não terei tempo de finalizar. (Semana Corrida)
    */
    public static function select () {

        if (empty(RequestReader::$requestJsonValue['telefone'])) {

            APIReturn::makeJson(false, 'É obrigatoria a informação de telefone.');

        }

        $additionalWhere = '';

        if (!empty(RequestReader::$requestJsonValue['entregue'])) {

            $additionalWhere = ' AND entregue = :entregue ';

        }

        $currentOperation = PDOConnect::$DB->prepare
        (

            '
            SELECT
                b.sabor, b.tamanho, a.nome, a.endereco, a.telefone, a.entregue
                
            FROM
                tb_pedido AS a 
                    
            INNER JOIN 
                    tb_pizza AS b ON (a.pizza_id = b.id)
            
            WHERE
                a.telefone = :telefone
            ' . $additionalWhere
        );

        $currentOperation->bindValue(':telefone', RequestReader::$requestJsonValue['telefone']);

        if (!empty(RequestReader::$requestJsonValue['entregue'])) {

            $currentOperation->bindValue(':entregue',
                RequestReader::$requestJsonValue['entregue']
                    ? 1
                    : 0
            );

        }

        $currentOperation->execute();

        APIReturn::makeJson(true, $currentOperation->fetchAll(PDO::FETCH_ASSOC));

    }

    public static function finish () {

        if (empty(RequestReader::$requestJsonValue['telefone']) || empty(RequestReader::$requestJsonValue['nome'])) {

            APIReturn::makeJson(false, 'É obrigatoria a informação de nome e telefone.');

        }

        $currentOperation = PDOConnect::$DB->prepare
        (

            '
            UPDATE tb_pedido SET entregue = 1 WHERE telefone = :telefone AND nome = :nome
            '
        );

        $currentOperation->bindValue(':telefone', RequestReader::$requestJsonValue['telefone']);
        $currentOperation->bindValue(':nome', RequestReader::$requestJsonValue['nome']);

        $currentOperation->execute();

        APIReturn::makeJson(true, 'Pedido finalizado com sucesso.');


    }

}