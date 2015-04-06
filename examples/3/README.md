# P.S:
You can inject custom add ons, I mean, event-subscribers on your application. Take for example a case which you're building an API that relies entirely on JSON request bodies? You just need to plug-it on, e.g:

```PHP
public function __construct()
{
    // ...
    $eventDispatcher = new \Symfony\Component\EventDispatcher\EventDispatcher();
    $eventDispatcher->addSubscriber(new \CotaPreco\Addons\AcceptsJsonRequestBody());

    parent::__construct(
        // ...
        $eventDispatcher
    );
}
```

*(...work in progress).*
