<?php

require 'PDOConnect.php';
require 'APIReturn.php';
require 'RequestReader.php';
require 'Pedido.php';
require 'Pizza.php';

//Inicia Conexao automaticamente
(new PDOConnect());

//Pega Valor do Request
(new RequestReader('json'));