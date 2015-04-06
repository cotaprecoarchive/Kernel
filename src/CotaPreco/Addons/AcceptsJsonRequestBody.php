<?php

namespace CotaPreco\Addons;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class AcceptsJsonRequestBody implements EventSubscriberInterface
{
    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['replaceRequestBodyIfNecessary', 0]
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function replaceRequestBodyIfNecessary(GetResponseEvent $event)
    {
        /* @var Request $request */
        $request = $event->getRequest();

        /* @var string[] $acceptableContentTypes */
        $acceptableContentTypes = $request->getAcceptableContentTypes();

        if (! in_array('application/json', $acceptableContentTypes, true)) {
            return;
        }

        $jsonRequestBody = json_decode($request->getContent(), true);

        if (! is_array($jsonRequestBody)) {
            $jsonRequestBody = [];
        }

        $request->request->replace($jsonRequestBody);
    }
}
