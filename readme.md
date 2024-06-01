# Queues in Laravel

## Normal Queues

https://github.com/Ruslan-Aliyev/laravel-queue/blob/master/queue.md

## RabbitMQ

### Start as normal queue

**In Producer:**

In `.env` make `QUEUE_CONNECTION=database` & fill the database connection credentials

```
php artisan queue:table
php artisan migrate
```

`php artisan make:job JobCreated`

```php
private $data;

public function __construct($data)
{
    $this->data = $data;
}

public function handle()
{
    //
}
```

`php artisan make:command FireJob`

```php
protected $signature = 'fire';

protected $description = 'Fire JobCreated';

public function handle()
{
    echo "Job Has Been Fired" . PHP_EOL;
    \App\Jobs\JobCreated::dispatch(['somekey' => 'somevalue']);
}
```

![](/Illustrations/normal_queue_result.png)

### Laravel > RabbitMQ

**Install RabbitMQ:**

Install and setup RabbitMQ (on Windows): https://www.youtube.com/watch?v=KhYiaEOrw7Q

Admin panel: http://localhost:15672 . Credentials guest/guest

![](/Illustrations/start_rabbitmq.png)

**In Producer:**

`composer require vladimir-yuldashev/laravel-queue-rabbitmq`

In `.env` 
```
QUEUE_CONNECTION=rabbitmq

RABBITMQ_HOST=127.0.0.1
RABBITMQ_PORT=5672
RABBITMQ_USER=guest
RABBITMQ_PASSWORD=guest
RABBITMQ_VHOST=/
```

In `config/queue.php`'s `connections` array, add the `rabbitmq` sub-array (see `config/queue.php`)

Leave `JobCreated` and `FireJob` as they are.

Run `php artisan fire`, then run php `artisan queue:work` in another terminal, and then see the results in RabbitMQ

![](/Illustrations/laravel_to_rabbitmq_result.png)

### Tutorials

- https://www.youtube.com/watch?v=deG25y_r6OY
- https://www.youtube.com/watch?v=K-xzRM6EKHg (Very Good)
- https://dev.to/dendihandian/rabbitmq-queue-driver-for-laravel-3ng4
- https://www.youtube.com/watch?v=Cie5v59mrTg
- https://www.youtube.com/watch?v=m-hNL87-lFo&list=PLcjapmjyX17hJZ-shzRMxTus0aMw0EVVB&index=8
- https://laravel-news.com/laravel-rabbitmq-queue-driver
- https://laravel-news.com/laravel-jobs-queues-101
- https://www.youtube.com/watch?app=desktop&v=bj4GFsv3_Yc
- https://www.youtube.com/watch?v=GMmRtSFQ5Z0

### Laravel 1 > RabbitMQ > Laravel 2

Copy `.env` & `config/queue.php` from Producer to Consumer

**In Consumer:**

`php artisan make:job JobCreated`

```php
private $data;

public function __construct($data)
{
    $this->data = $data;
}

public function handle()
{
    echo 'Received: JobCreated' . PHP_EOL;
    echo json_encode($this->data) . PHP_EOL;
}
```

Run `php artisan rabbitmq:consume`

**In Producer:**

Run `php artisan fire` ~and `php artisan queue:work`~

![](/Illustrations/laravel_to_rabbitmq_to_laravel_results.png)

### Tutorials

- https://mubaraktech.hashnode.dev/how-to-implement-rabbitmq-messaging-between-two-laravel-apps-part-one-cklm6d32v04syr8s18jk09k2z
- https://codetutam.com/rabbitmq-va-laravel/?amp=1
- https://tamrakar-shreyaa.medium.com/implement-rabbitmq-messaging-between-two-laravel-2348a00a0805
- https://blog.alessandrodorazio.it/awesome-laravel-how-to-use-rabbitmq-to-handle-communication-between-microservices-97b42f91aa3
- https://medium.com/@davrv93/integrating-rabbitmq-and-laravel-2-5-queues-a023d03542da

## Kafka

Todo

### Tutorials

- https://www.youtube.com/playlist?list=PLt1SIbA8guusxiHz9bveV-UHs_biWFegU 
- https://www.youtube.com/watch?v=e9D7_SQwdvc https://www.youtube.com/watch?v=udnX21__SuU 
- https://medium.com/@subhamchbt/use-kafka-in-laravel-for-real-time-communication-between-servers-b6d5aeaddbea 
- https://medium.com/@popov256/splitting-the-monolith-with-php-and-kafka-f2a274badd9f 
- https://forum.confluent.io/t/how-to-use-rest-api-kafka-with-php-application/3142 
- https://doc.akka.io/guide/how-to/projection-kafka.html 
- https://medium.com/@subhamchbt/use-kafka-in-laravel-for-real-time-communication-between-servers-b6d5aeaddbea 
- https://laravel-news.com/laravel-kafka-package 
- https://github.com/aplr/kafkaesk 
- https://medium.com/simform-engineering/integrating-apache-kafka-in-laravel-real-time-database-synchronization-with-debezium-connector-2506bc8f37a7 
