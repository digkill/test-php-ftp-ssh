<?php
/**
 * Класс реализует коннект на SSH
 * ОС Nix системы
 */
namespace SSHConnect;

include_once 'SSHConnectInterface.php';

use SSHConnectInterface\SSHConnectInterface;

class SSHConnect implements SSHConnectInterface
{
    private $connectId;

    private $currentPath = '';

    public function __construct($hostname, $user, $password, $port = 22)
    {
        $this->connect($hostname, $user, $password, $port);
    }

    public function connect($hostname, $user, $password, $port = 22)
    {
        $this->connectId = ssh2_connect($hostname, $port);

        if (empty($this->connectId)) {
            throw new \Exception('SSH connection has failed!');
        }

        $loginResult = ssh2_auth_password($this->connectId, $user, $password);

        if (!$loginResult) {
            throw new \Exception('SSH login has failed!');
        }

        return $this;
    }

    public function cd($path = "/")
    {
        $this->currentPath = $path."/";
        return $this;
    }

    public function upload($fileName, $create_mode = 0644)
    {
        $this->uploadFile($fileName, $fileName, $create_mode);
        return $this;
    }

    public function download($fileName, $fileSave)
    {
        $this->downloadFile($fileName, $fileSave);
        return $this;
    }


    private function uploadFile($localFile, $remoteFile, $create_mode) {

        $result = ssh2_scp_send($this->connectId, $localFile, $this->currentPath.$remoteFile, $create_mode);

        if ($result === false) {
            throw new \Exception('Upload!');
        }

        return $this;
    }


    private function downloadFile($localFile, $remoteFile) {

        if (!file_exists($localFile)) {
            $handle = @fopen($localFile, 'w');
            @fclose($handle);
        }

        if (!is_writable($localFile)) {
            throw new \Exception('Not Writable!');
        }

        $result = @ssh2_scp_recv($this->connectId, $this->currentPath.$remoteFile, $localFile);

        if ($result === false) {
            throw new \Exception('Not Download!');
        }

        return $this;
    }

    /**
     * Выполняет команды
     *
     * @param $cmd
     * @param bool $trimOutput
     * @return bool|string
     */
    public function exec($cmd, $trimOutput = true) {
        $stream  = ssh2_exec($this->connectId, $cmd);
        stream_set_blocking($stream, true);

        $content = stream_get_contents($stream);
        $content = $trimOutput ? trim($content) : $content;

        $stderr_stream   = ssh2_fetch_stream($stream, SSH2_STREAM_STDERR);
        $content_error   = stream_get_contents($stderr_stream);

        return  strlen($content_error) ? false : $content;
    }


    public function pwd() {
        $pwd = $this->exec('cd '.$this->currentPath.'; pwd');
        return $pwd;
    }


    public function close()
    {
        unset($this->connectId);
    }

    public function __destruct() {
        $this->close();
    }
}