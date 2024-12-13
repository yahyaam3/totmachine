<?php
namespace App;

use Emeset\Container as EmesetContainer;
use PDO;

class Container extends EmesetContainer {
    public function __construct($config){
        parent::__construct($config);

        $this["db"] = function($c){
            $dbconf = $c["config"]["db"];
            $pdo = new PDO($dbconf["dsn"], $dbconf["user"], $dbconf["pass"]);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $pdo;
        };

        // Controllers
        $this["\App\Controllers\UsersController"] = function($c){
            return new \App\Controllers\UsersController($c->get("db"));
        };

        $this["\App\Controllers\AuthController"] = function($c){
            return new \App\Controllers\AuthController($c->get("db"));
        };

        $this["\App\Controllers\MachinesController"] = function($c){
            return new \App\Controllers\MachinesController($c->get("db"));
        };

        $this["\App\Controllers\IncidentsController"] = function($c){
            return new \App\Controllers\IncidentsController($c->get("db"));
        };

        $this["\App\Controllers\MaintenanceController"] = function($c){
            return new \App\Controllers\MaintenanceController($c->get("db"));
        };

        $this["\App\Controllers\PublicController"] = function($c){
            return new \App\Controllers\PublicController($c->get("db"));
        };

        $this["\App\Controllers\AjaxController"] = function($c){
            return new \App\Controllers\AjaxController($c->get("db"));
        };
    }
}