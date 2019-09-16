<?php
declare(strict_types=1);

namespace CLSlim\Controllers\Sample;

use Slim\Interfaces\RouteCollectorProxyInterface;
use CLSlim\Controllers\IController;

class SampleController implements IController
{
    public function register(RouteCollectorProxyInterface $group): void
    {
        $group->get('/sample/{id}', SampleGetAction::class)
            ->add(SampleGetValidator::class);
    }
}
