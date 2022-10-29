<?php

namespace winv\mf\router;

use winv\mf\auth\AbstractAuthentification;

class Router extends AbstractRouter
{
    /**
     * addRoute : ajouter une route avec un nom, une action lié à son controller et un niveau d'accès
     */
    public function addRoute(string $name, string $action, string $ctrl, int $level = AbstractAuthentification::ACCESS_LEVEL_NONE): void
    {
        self::$aliases[$name] = $action;
        self::$routes[$action] = [$ctrl, $level];
    }

    /*
     * run : exécuter une route en fonction de la requête 
     * (l'action est récupérée depuis l'attribut $this->request)
     */
    public function run(): void
    {
        if (!empty($this->request->get['action'])){
            $action = self::$routes[$this->request->get['action']];
            if (isset($action))
                if (AbstractAuthentification::checkAccessRight($action[1])) (new $action[0])->execute();
            else (new self::$routes[self::$aliases['default']][0])->execute();
        }else (new self::$routes[self::$aliases['default']][0])->execute();
    }

    public function setDefaultRoute(string $action): void
    {
        self::$aliases['default'] = $action;
    }

    /*
     * urlFor : retourne l'URL d'une route depuis son alias cette méthode est utile 
     * pour écrire les lien HTML et les actions des formulaires.
     * Elle permet de générer la valeur href pour les balises <a href="...">lien</a> 
     */
    public function urlFor(string $name, array $params = []): string
    {
        $action = self::$aliases[$name];
        $url = $this->request->script_name .  '?action=' . $action;
        if (isset($params)) {
            for ($i = 0; $i < count($params); $i++) {
                $url .= '&amp;' . $params[$i][0] . '=' . $params[$i][1];
            }
        }
        return $url;
    }

    /**
     * executeRoute : force l'execution d'une route
     */
    public static function executeRoute($alias): void
    {
        $action = self::$routes[self::$aliases[$alias]];
        $route = new $action[0];
        $route->execute();
    }
}
