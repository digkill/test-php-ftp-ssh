<?php
/**
 * Класс реализует коннект на FTP
 */

namespace FTPConnect;

include_once 'FTPConnectInterface.php';

use FTPConnectInterface\FTPConnectInterface;

class FTPConnect implements FTPConnectInterface
{
    private $connectId;

    public function __construct($hostname, $user, $password, $port, $isPassive)
    {
        $this->connect($hostname, $user, $password, $port, $isPassive);
    }

    public function connect($hostname, $user, $password, $port, $isPassive)
    {
        $this->connectId = ftp_connect($hostname);

        if (empty($this->connectId)) {
            throw new \Exception('FTP connection has failed!');
        }

        $loginResult = ftp_login($this->connectId, $user, $password);

        if (!$loginResult) {
            throw new \Exception('FTP login has failed!');
        }

        ftp_pasv($this->connectId, $isPassive);

        return $this->connectId;
    }

    public function cd($path = "/")
    {
        $chdir = ftp_chdir($this->connectId, $path);

        if ($chdir) {
            echo ftp_pwd($this->connectId);
            // TODO: Logger
        }
    }

    public function download($fileName, $fileSave)
    {
        $this->downloadFile($fileName, $fileSave);
    }

    public function upload($fileName)
    {
        $this->uploadFile($fileName, $fileName);
        return $this;
    }

    public function close()
    {
        if (!empty($this->connectId)) {
            ftp_close($this->connectId);
        }
        return true;
    }

    private function uploadFile($file, $remoteFile)
    {
        $asciiArray = array('txt', 'csv');
        $extension = array_reverse(explode('.', $file))[0];

        if (in_array($extension, $asciiArray)) {
            $mode = FTP_ASCII;
        } else {
            $mode = FTP_BINARY;
        }

        $upload = ftp_put($this->connectId, $remoteFile, $file, $mode);

        if (empty($upload)) {
            throw new \Exception('FTP upload has failed!');
        }

        return true;
    }

    private function downloadFile($file, $remoteFile)
    {
        $download = ftp_get($this->connectId, $remoteFile, $file, FTP_ASCII);

        if (empty($download)) {
            throw new \Exception('FTP download has failed!');
        }

        return true;
    }

    public function pwd()
    {
        $result = ftp_pwd($this->connectId);
        if (empty($result)) {
            // TODO: Logger
        }
        return $result;
    }

    public function exec($command)
    {
        $result = ftp_exec($this->connectId, $command);
        if (empty($result)) {
            throw new \Exception('Not command run!');
        }
        return $result;
    }

    public function __destruct() {
        $this->close();
    }
}