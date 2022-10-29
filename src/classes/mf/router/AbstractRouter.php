<?php

namespace winv\mf\router;

use \winv\mf\utils\HttpRequest;

abstract class AbstractRouter
{

    protected ?HttpRequest $request = null;

    static public array $routes = [];
    static protected array $aliases = [];

    public function __construct()
    {
        $this->request = new \winv\mf\utils\HttpRequest();
    }

    abstract public function addRoute(string $name, string $action, string $ctrl, int $level): void;

    abstract public function setDefaultRoute(string $action): void;

    abstract public function run(): void;

    abstract public function urlFor(string $name, array $params = []): string;
}
