<?php
require_once __DIR__ . '/vendor/autoload.php';
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;
$connection = new AMQPStreamConnection('localhost', 5672, 'admin', 'admin');
$channel = $connection->channel();
$channel->queue_declare('hello', false, false, false, false);
$msg = new AMQPMessage($argv[1] ?? 'Hello World!');
echo sprintf('[x] Sent "%d"%s', $msg->body, "\n");
$channel->basic_publish($msg, '', 'hello');
$channel->close();
$connection->close();