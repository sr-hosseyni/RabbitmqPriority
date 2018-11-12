<?php
require_once __DIR__ . '/vendor/autoload.php';

use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
use PhpAmqpLib\Wire\AMQPTable;

$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'admin');
$channel = $connection->channel();
$tbl = new AMQPTable();
$tbl->set('x-max-priority', 10);
$channel->queue_declare('hello', false, false, false, false, false, $tbl);

$msg = new AMQPMessage($argv[1] ?? 'Hello World!', ['priority' => $argv[2] ?? 0]);

echo sprintf('[x] Sent "%d"%s', $msg->body, "\n");
$channel->basic_publish($msg, '', 'hello');
$channel->close();
$connection->close();
