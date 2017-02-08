<?php
namespace FTPConnectFactory;

include_once 'FileTransferAbstract.php';
include_once 'FTPConnect.php';

use FileTransfer as FT;
use FTPConnect\FTPConnect;

class FTPConnectFactory extends FT\FileTransferAbstract
{
    private $isPassive = false;

    public function setPassive($isPassive)
    {
        $this->isPassive = $isPassive;
        return $this;
    }

    public function getConnection($hostname, $user, $password, $port = 21)
    {
        return new FTPConnect($hostname, $user, $password, $port, $this->isPassive);
    }

}