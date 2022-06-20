<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Junges\Kafka\Contracts\KafkaConsumerMessage;
use Junges\Kafka\Facades\Kafka;

class ListenMessages extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'messages:listen';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Start listen messages';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $name = $_ENV['CONTAINER_NAME'];

        $consumer = Kafka::createConsumer(['topic'], 'group')
            ->withHandler(function (KafkaConsumerMessage $message) use ($name) {
                $body = $message->getBody();
                $value = $body['message'];
                $this->line("{$name}:message:{$value}");

                sleep(3);
            })
            ->build();

        $consumer->consume();

        return 0;
    }
}
