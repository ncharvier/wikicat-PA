<?php
require_once('logger.php');

$logger =  Logger::getInstance();
$logger->write_log('log.txt', 'My name is Charles');
//echo "<pre>";
//echo $logger->read_log('log.txt');

?>  