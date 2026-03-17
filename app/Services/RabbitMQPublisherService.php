<?php


namespace App\Service;
use Illuminate\Support\Facades\Queue;
use PhpAmqpLib\Message\AMQPMessage;


class RabbitMQPublisherService{
    public function publish(array $data, string $key, string $exchange = 'folder_events'){
        $connection = Queue::connection('rabbitmq');
        $channel = $connection->getChannel();

        $message = new AMQPMessage(
            json_encode($data),['delivery_mode' => AMQPMessage::DELIVERY_MODE_PERSISTENT]
        );
        $channel->basic_publish($message, $exchange, $key);
    }
}