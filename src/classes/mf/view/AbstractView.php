<?php

namespace winv\mf\view;

use \winv\mf\router\Router;
use \winv\mf\utils\HttpRequest;

abstract class AbstractView
{
    protected ?HttpRequest $request = null;
    protected ?Router $router = null;

    static protected array $style_sheets = [];
    static protected array $scriptes_js = [];
    static protected string $app_title = "";

    /* Ces Données sont passée par les contrôleurs lors de la
     * création des vues. Ce sera généralement des objets
     * modèles ou des tableau d'objets modèles.
     */
    protected mixed $data = null;

    /* 
     * $data : selon la vue, une instance d'un  modèle ou un tableau d'instances d'un modèle.
     */
    public function __construct(mixed $data = null)
    {
        $this->request = new HttpRequest();
        $this->router = new Router();

        $this->data = $data;
    }

    static public function addStyleSheet(string $css_files): void
    {
        self::$style_sheets[] = $css_files;
    }

    static public function addScriptJs(string $js_files): void
    {
        self::$scriptes_js[] = $js_files;
    }

    static public function setAppTitle(string $title): void
    {
        self::$app_title = $title;
    }

    abstract protected function makeBody(): string;

    /* Méthode makePage
     * 
     * cette méthode génère le code HTML d'une page complète depuis
     * le <doctype jusqu'au </html>. 
     * 
     * Elle définit les entêtes HTML, le titre de la page et lie les
     * feuilles de style. Le contenu du document est le résultat de la
     * méthode makeBody des sous-classes. 
     *
     * Elle utilise la syntaxe HEREDOC pour définir un patron et
     * écrire la chaîne de caractère de la page entière. Voir la
     * documentation ici:
     *
     * http://php.net/manual/fr/language.types.string.php#language.types.string.syntax.heredoc
     *
     */
    public function makePage()
    {

        /* Fixer le titre du document */

        $title = self::$app_title;

        /* Lier les feuilles de style */

        $app_root = $this->request->root;
        $styles = '';
        foreach (self::$style_sheets as $file)
            $styles .= '<link rel="stylesheet" href="' . $app_root . '/' . $file . '"> ';

        $scripts = '';
        foreach (self::$scriptes_js as $file)
            $scripts .= '<script src="' . $app_root . '/' . $file . '"> ';

        $body = $this->makeBody();

        /*
         * Construire la structure de la page
         */
        $html = <<<EOT
<!DOCTYPE html>
<html lang="fr">
            
    <head>
        <meta charset="utf-8">
        <title>${title}</title>
	    ${styles}
    </head>

    <body>
        
       ${body}

       ${scripts}
    </body>
</html>
EOT;

        /*
         * Affichage de la page 
         * C'est la seule instruction echo dans toute l'application 
         */
        echo $html;
    }
}
