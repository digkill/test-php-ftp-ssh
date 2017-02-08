<?php
namespace SSHConnectInterface;

interface SSHConnectInterface
{
    /**
     * Подключение к хосту
     *
     * @param $hostname
     * @param $user
     * @param $password
     * @param $isPassive
     * @return mixed
     */
    public function connect($hostname, $user, $password, $isPassive);

    /**
     * Перейти к заданной категории
     *
     * @param $path
     * @return mixed
     */
    public function cd($path = "/");

    /**
     * Скачать файл
     *
     * @param $fileName
     * @param $fileSave
     * @return mixed
     */
    public function download($fileName, $fileSave);

    /**
     * Закачать файл
     *
     * @param $fileName
     * @param $create_mode
     * @return mixed
     */
    public function upload($fileName, $create_mode);

    /**
     * Закрыть соединение
     *
     * @return mixed
     */
    public function close();

    /**
     * @param $cmd
     * @param bool $trimOutput
     * @return mixed
     */
    public function exec($cmd, $trimOutput = true);

    /**
     * Вывод текущего пути
     *
     * @return mixed
     */
    public function pwd();

}