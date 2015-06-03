<?php

namespace CotaPreco\Addons;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\AcceptHeader;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class AcceptsOnlyJson implements EventSubscriberInterface
{
    /**
     * @var Response
     */
    private $responseToSend;

    /**
     * @param Response $preferredResponse
     */
    public function __construct(Response $preferredResponse = null)
    {
        $this->responseToSend = $preferredResponse ?: new Response(null, Response::HTTP_NOT_ACCEPTABLE);
    }

    /**
     * {@inheritDoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            KernelEvents::REQUEST => ['onRequest', 10]
        ];
    }

    /**
     * @param GetResponseEvent $event
     */
    public function onRequest(GetResponseEvent $event)
    {
        if (! $event->isMasterRequest()) {
            return;
        }

        $accept = AcceptHeader::fromString($event->getRequest()->headers->get('Accept'));

        $acceptsAny  = $accept->has('*/*');
        $acceptsJson = $accept->has('application/json');

        if ($acceptsAny || $acceptsJson) {
            return;
        }

        $event->setResponse($this->responseToSend);
    }
}
