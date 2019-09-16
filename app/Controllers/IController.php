<?php
declare(strict_types=1);

namespace CLSlim\Controllers;

use Slim\Interfaces\RouteCollectorProxyInterface;

/**
 * Interface IController
 *
 * @package CLSlim\Controllers
 */
Interface IController
{
	/**
	 * @param RouteCollectorProxyInterface $group
	 * @return mixed
	 */
    public function register(RouteCollectorProxyInterface $group);
}
