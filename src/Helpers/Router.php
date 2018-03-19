<?php

namespace SagarYonjan\VueDatatable\Helpers;

class Router
{
    /**
     * $classes path
     *
     * @var string
     */
    public $classes_path = '/Http/Controllers/DataTable/';

    /**
     * NameSpace
     *
     * @var string
     */
    public $namespace =  'App\Http\Controllers\DataTable\\';

    /**
     *
     * @param $classPath
     * @return array
     */
    public function datatable($classPath)
    {
        $segments = explode('/', $classPath);

        $segments = explode('\\', $segments[count($segments) - 1]);

        $controllerName = explode('.', $segments[count($segments) - 1]);

        $dataTableControllers = explode('.',$this->namespace . $segments[count($segments) - 1]);

        return [
            'controller' => $controllerName[0],
            'route'      => $dataTableControllers[0],
        ];
    }

    /**
     * @return array
     */
    public function getRoutes()
    {
        $classPaths = glob(app_path() . $this->classes_path.'*.php');

        $classes = [];

        foreach ($classPaths as $classPath) {

            $data = $this->datatable($classPath);

            $classes[$data['controller']] = $this->getName($data['route']);
        }

        return $classes;
    }

    /**
     * Get Name
     * @param $controllers
     * @return mixed
     */
    public function getName($controllers)
    {
        $controller = app($controllers);

        if(property_exists($controller, 'route'))
            return $controller->route;
        else
            return app($controller->model)->getTable();

    }
}