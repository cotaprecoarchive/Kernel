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
    private $responseWhenNotAcceptable;

    /**
     * @param Response $notAcceptableResponse
     */
    public function __construct(Response $notAcceptableResponse = null)
    {
        $emptyNotAcceptableResponse = new Response(
            null,
            Response::HTTP_NOT_ACCEPTABLE
        );

        $this->responseWhenNotAcceptable = (
            $notAcceptableResponse ?: $emptyNotAcceptableResponse
        );
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

        $acceptHeaderAsString = $event->getRequest()->headers->get('Accept');

        $accept = AcceptHeader::fromString($acceptHeaderAsString);

        $acceptsAnyContentType  = $accept->has('*/*');
        $acceptsApplicationJson = $accept->has('application/json');

        if ($acceptsAnyContentType || $acceptsApplicationJson) {
            return;
        }

        $event->setResponse($this->responseWhenNotAcceptable);
    }
}
