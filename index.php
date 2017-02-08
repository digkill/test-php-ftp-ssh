<?php
/**
 * Тестовое задание Едифанов Виталий Валерьевич
 */

namespace FTCommon;

include_once 'FileTransferAbstract.php';
include_once 'Config.php';

use FileTransfer as FT;

try {
    $conn = FT\FileTransferAbstract::getConnectFactory('ssh')
        ->getConnection('88.201.248.163', '*', '*', 22);

    $conn->cd('test')
        ->upload('dump.tar.gz')
        ->download('locdump.tar.gz', 'dump.tar.gz')
        ->close();

} catch (Exception $e) {
    echo $e->getMessage();
}

$conn = FT\FileTransferAbstract::getConnectFactory()->setPassive(true)->getConnection('138.201.162.116', '*', '*');
try {
    $conn->cd('/upload');
    echo $conn->pwd() . "\n";
    $conn->upload('test.txt');
  //  print_r($conn->exec('ls -al'));
} catch (Exception $e) {
    echo $e->getMessage();
}


