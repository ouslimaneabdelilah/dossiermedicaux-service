<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Exchange\AMQPExchangeType;

class RabbitMQSetupBindings extends Command
{

    
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'rabbitmq:setup-bindings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Declare the folder_service_queue and bind it to the patients_events topic exchange';

    /**
     * Execute the console command.
     */
    public function handle() {
        $connection = new AMQPStreamConnection(
            env('RABBITMQ_HOST', 'rabbit'),
            (int) env('RABBITMQ_PORT', 5672),
            env('RABBITMQ_LOGIN', 'guest'),
            env('RABBITMQ_PASSWORD', 'guest'),
            env('RABBITMQ_VHOST', '/'),
        );
        $channel = $connection->channel();
        
        $exchange = 'folder_events';
        $queue = 'folder_events_queue';

        $channel->exchange_declare($exchange, AMQPExchangeType::TOPIC, false, true, false);
        $this->info("$exchange have been created");
        
        $channel->queue_declare($queue, false, true, false, false);
        $this->info("$queue have been created");

        $routingKeys = ['folder.deleted'];

        foreach($routingKeys as $key){
            $channel->queue_bind($queue, $exchange,  $key);
            $this->info("bound routing key: {$key} to the {$queue}");
        }

        $channel->close();
        $connection->close();

        return self::SUCCESS;
    }
}
