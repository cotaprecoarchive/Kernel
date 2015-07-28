<?php

/*
 * Copyright (c) 2015 Cota Preço
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

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
     * @param  GetResponseEvent $event
     * @return null
     */
    public function onRequest(GetResponseEvent $event)
    {
        if (! $event->isMasterRequest()) {
            return null;
        }

        $accept = AcceptHeader::fromString($event->getRequest()->headers->get('Accept'));

        if ($accept->has('*/*') || $accept->has('application/json')) {
            return null;
        }

        $event->setResponse($this->responseToSend);
    }
}
