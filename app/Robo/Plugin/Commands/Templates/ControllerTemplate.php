<?php
declare(strict_types=1);

namespace CLSlim\Controllers\TableAlias;

use Slim\Interfaces\RouteCollectorProxyInterface;
use CLSlim\Controllers\IController;

/**
 * Class TableAliasController
 *
 * @package CLSlim\Controllers\TableAlias
 */
class TableAliasController implements IController
{
    public function register(RouteCollectorProxyInterface $group): void
    {
        $group->get('/%route%/query/{value}', TableAliasQueryAction::class)
            ->add(TableAliasQueryValidator::class);
        $group->get('/%route%/{id}', TableAliasGetAction::class);
        $group->post('/%route%', TableAliasPostAction::class)
            ->add(TableAliasWriteValidator::class);
        $group->patch('/%route%', TableAliasPatchAction::class)
            ->add(TableAliasWriteValidator::class);
        $group->delete('/%route%/{id}', TableAliasDeleteAction::class);
    }
}
