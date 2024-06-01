# Normal Laravel Queues

- Very good tutorial: https://www.youtube.com/watch?v=fFy-s7_SbYM
- https://laravel-guide.readthedocs.io/en/latest/queues/
- https://youtu.be/rVx8xKisbr8?si=dxORNP2DzY_94iAk

Use emailing functionality for example.

1. Get mail server credentials/configs sorted
2. In `routes/web.php`
```php
Route::get('sendEmail', function () {
    Mail::send(new SendEmailMailable());
});
```
3. `php artisan make:mail SendEmailMailable`. `app/Mail/SendEmailMailable.php` is created. We should make a view to send for its build function. But for this example, just use the `welcome.blade.php`. 
4. `{domain}/sendEmail` , **But it's slow and it blocks**.

5. Start using queues: https://laravel.com/docs/8.x/queues#driver-prerequisites

6. Configure DB creds in `.env`

7. Run
```
php artisan queue:table
php artisan migrate
```

8. `php artisan make:job SendMailJob`

9. Move this line `Mail::to('someone@gmail.com')->send(new SendEmailMailable());` from `routes/web.php` to `App\Jobs\SendMailJob::handle`

10. Dispatch the job from `routes/web.php`

11. In `.env`: `QUEUE_CONNECTION=database` instead of `sync`. (This affects `config/queue.php`)

12. Now if you go to `{domain}/sendEmail` , the reaction is instant. But email isn't sent. Instead it's queued up in the DB `jobs` table. 

13. Now we just need another process to 'flush' those jobs. https://laravel.com/docs/8.x/queues#running-the-queue-worker

14. Run `php artisan queue:work` in another terminal.

## Multiple queues

http://laravel.at.jeffsbox.eu/laravel-5-queues-multiple-queues

config/queue.php
```php
'connections' => [
	...
        'database' => [
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'default',
            'retry_after' => 90,
	],

        'another' => [ // another queue
            'driver' => 'database',
            'table' => 'jobs',
            'queue' => 'low',
            'retry_after' => 90,
        ],
```

routes/web.php
```php
    $job = (new SendMailJob)
        ->delay(now()->addSeconds(5));
    dispatch($job);

    // another queue
    $anotherJob = (new AnotherJob)
        ->onQueue('another')
        ->delay(now()->addSeconds(5));
    dispatch($anotherJob);
```

`php artisan queue:work --queue=database,another`

## Failed Jobs

https://laravel.com/docs/8.x/queues#dealing-with-failed-jobs 

## Batches and Chains

Chains - Serial: https://laravel.com/docs/8.x/queues#job-chaining

Batches - "Parallel": https://laravel.com/docs/8.x/queues#job-batching

https://github.com/laravel/framework/issues/35447
