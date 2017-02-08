<?php
namespace FTPConnectInterface;

interface FTPConnectInterface
{
    /**
     * Подключение к хосту
     *
     * @param $hostname
     * @param $user
     * @param $password
     * @param $port
     * @param $isPassive
     * @return mixed
     */
    public function connect($hostname, $user, $password, $port, $isPassive);

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
     * @return mixed
     */
    public function upload($fileName);

    /**
     * Закрыть соединение
     *
     * @return mixed
     */
    public function close();

    /**
     * Выполнить команду
     *
     * @param $command
     * @return mixed
     */
    public function exec($command);

    /**
     * Вывод текущего пути
     *
     * @return mixed
     */
    public function pwd();


}