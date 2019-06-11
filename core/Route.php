<?php
namespace core;

/**
 * Class Route
 */

class Route
{
    public static function start()
    {
        // контроллер и действие по умолчанию
        $controller_name = 'Login';
        $action_name = 'Index';

        $route=str_replace("r=", "", $_SERVER['QUERY_STRING']);
        $routes = explode('/', $route);

        // получаем имя контроллера
        if (!empty($routes[0])) {
            $controller_name = $routes[0];
        }
        // получаем имя экшена
        if (!empty($routes[1])) {
            $action_name = $routes[1];
        }

        // добавляем префиксы
        $controller_name = 'Controller'.ucfirst($controller_name);
        $action_name = 'action'.ucfirst($action_name);

        // подцепляем файл с классом контроллера
        $controller_file = $controller_name.'.php';
        $controller_path = "controllers/".$controller_file;
        if (file_exists($controller_path)) {
            include "controllers/".$controller_file;
        } else {
            die("Страницы не существует");
        }

        $controller_class="Controllers\\".$controller_name;
        // создаем контроллер
        $controller = new $controller_class;
        $action = $action_name;

        if (method_exists($controller, $action)) {
            // вызываем действие контроллера
            $controller->$action();
        } else {
            die("Страницы не существует");
        }
    }
}