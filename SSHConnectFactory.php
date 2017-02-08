<?php
namespace SSHConnectFactory;

include_once 'FileTransferAbstract.php';
include_once 'SSHConnect.php';

use FileTransfer as FT;
use SSHConnect\SSHConnect;

class SSHConnectFactory extends FT\FileTransferAbstract
{

    public function  getConnection($hostname, $user, $password, $port)
    {
        return new SSHConnect($hostname, $user, $password, $port);
    }

}