<?php
$updatedAt = new \DateTime('now');
var_dump($updatedAt);
echo $updatedAt->getTimestamp();
echo PHP_EOL;
echo date('Y-m-d H:i:s',$updatedAt->getTimestamp());
echo PHP_EOL;
