<?php

use CotaPreco\Action\ExecutableHttpActionInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
final class MultiplyTwoNumbers implements ExecutableHttpActionInterface
{
    /**
     * {@inheritDoc}
     */
    public function execute(Request $request)
    {
        $x = $request->get('x');
        $y = $request->get('y');

        return new Response(
            sprintf(
                '%s * %s = %s',
                $x,
                $y,
                $x * $y
            )
        );
    }
}
