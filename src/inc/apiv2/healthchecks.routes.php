<?php
use Psr\Http\Message\ResponseInterface as Response;
use Psr\Http\Message\ServerRequestInterface as Request;

use Slim\Routing\RouteCollectorProxy;

use DBA\Factory;
use DBA\HealthCheck;
use DBA\QueryFilter;
use DBA\OrderFilter;



require_once(dirname(__FILE__) . "/shared.inc.php");


class HealthCheckAPI extends AbstractBaseAPI {
    public static function getBaseUri(): string {
      return "/api/v2/ui/healthchecks";
    }
 
    public static function getDBAclass(): string {
      return HealthCheck::class;
    }

    protected function getFactory(): object {
      return Factory::getHealthCheckFactory();
    }

    public function getExpandables(): array {
      return ['crackerBinary', 'healthCheckAgents'];
    }
 
    protected function getFilterACL(): array {
      return [];
    }

    public function getFormFields(): array {
    // TODO Form declarations in more generic class to allow auto-generated OpenAPI specifications
    return  [];
    }

    protected function createObject($mappedQuery, $QUERY): int {
      $obj = HealthUtils::createHealthCheck(
        $mappedQuery['hashtypeId'],
        $mappedQuery['checkType'],
        $mappedQuery['crackerBinaryId']
      );

      return $obj->getId();
    }

    protected function deleteObject(object $object): void {
      HealthUtils::deleteHealthCheck($object->getId());
    }
}

HealthCheckAPI::register($app);