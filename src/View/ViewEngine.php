<?php

namespace Fibi\View;

class ViewEngine
{
    private string $viewDirectory;
    private ?string $mainLayout;

    public function __construct(string $viewDirectory) {
        $this->viewDirectory = $viewDirectory;
        $this->mainLayout = null;
    }

    /**
     * Establece un main layout para ser usado
     *
     * @param string $mainLayout Nombre del layout, no se debe poner extensión
     * @return void
     */
    public function setMainLayout(string $mainLayout) : void
    {
        $this->mainLayout = $mainLayout;
    }

    /**
     * Renderiza una vista HTML completa
     *
     * @param string $view Vista solicitada para ser renderizada
     * @param string|null $layout Layout solicitado para ser renderizado, si no es especificado se usa el main layout, si ese tampoco fue especificado no se usa layout
     * @return string Contenido HTML para ser desplegado en pantalla
     */
    public function render(string $view, ?string $layout = null) : string
    {
        $contentLayout = $this->getContentLayout($layout ?? $this->mainLayout ?? null);
        $contentView = $this->getContentView($view ?? null);
        
        if (is_null($contentLayout) || $contentLayout === "")
        {
            $contentLayout = "@content";
        }

        return str_replace("@content", $contentView, $contentLayout);
    }

    /**
     * Obtiene el HTML de una vista solicitada
     *
     * @param string $view Nombre de la vista (no es necesario incluir la extensión)
     * @return string Contenido HTML de la vista
     */
    public function getContentView(string $view) : string
    {
        return $this->getFileOutput("$this->viewDirectory\\$view.html");
    }

    /**
     * Obtiene el HTML del layout solicitado, en caso de no proveer un layout toma el default
     *
     * @param string|null $layout
     * @return string
     */
    public function getContentLayout(?string $layout = null) : string
    {
        if (is_null($layout))
        {
            return "";
        }

        return $this->getFileOutput("$this->viewDirectory\\layouts\\$layout.html");
    }

    /**
     * Devuelve el contenido de un archivo
     *
     * @param string $file URL del archivo
     * @return string Contenido del archivo
     */
    public function getFileOutput(string $file) : string 
    {
        // Guarda todo el contenido desplegado de PHP en un buffer
        ob_start();
        include_once($file);
        return ob_get_clean();
    }
}

?>