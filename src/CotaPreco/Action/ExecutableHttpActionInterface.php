<?php

namespace CotaPreco\Action;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
interface ExecutableHttpActionInterface
{
    /**
     * @param  Request $request
     * @return Response
     */
    public function execute(Request $request);
}
