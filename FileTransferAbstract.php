<?php
/**
 * Абстрактная фабрика, выбирает какое подключение использовать
 * По параметру typeConnect
 */

namespace FileTransfer;

include_once 'Config.php';
include_once 'FTPConnectFactory.php';
include_once 'SSHConnectFactory.php';

use Config\Config;
use FTPConnectFactory\FTPConnectFactory;
use SSHConnectFactory\SSHConnectFactory;

abstract class FileTransferAbstract
{

    public static function getConnectFactory($typeConnect = 'ftp')
    {
        Config::$typeConnect = $typeConnect;

        switch (Config::$typeConnect) {
            case 'ftp':
                return new FTPConnectFactory();
            case 'ssh':
                return new SSHConnectFactory();
        }
        throw new Exception('Bad config');
    }


    abstract public function getConnection($hostname, $user, $password, $port);
}