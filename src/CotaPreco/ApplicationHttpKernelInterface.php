<?php

namespace CotaPreco;

use Symfony\Component\HttpFoundation\Request;

/**
 * @author Andrey K. Vital <andreykvital@gmail.com>
 */
interface ApplicationHttpKernelInterface
{
    /**
     * @param  Request $request
     * @return void
     */
    public function handle(Request $request);
}
