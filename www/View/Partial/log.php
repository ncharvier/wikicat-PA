<?php
require_once('logger.php');

$logger = new Logger();
//$logger->write_log('log.txt', 'My name is Louis');
echo "<pre>";
echo $logger->read_log('log.txt');

?>  