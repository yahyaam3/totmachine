<?php
include "../vendor/autoload.php";

$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

$app = new \Emeset\Emeset($contenidor);

// Instances of middleware
$auth = new \App\Middleware\AuthMiddleware();
$supervisor = new \App\Middleware\SupervisorMiddleware();
$technician = new \App\Middleware\TechnicianMiddleware();
$admin = new \App\Middleware\AdminMiddleware();

// Public routes
$app->get("/", "\App\Controllers\PublicController:index");
$app->get("/public/register-incident", "\App\Controllers\PublicController:registerIncidentPublic");
$app->post("/public/store-incident", "\App\Controllers\PublicController:storeIncidentPublic");

$app->get("/login", "\App\Controllers\AuthController:showLogin");
$app->post("/login", "\App\Controllers\AuthController:login");
$app->get("/logout", "\App\Controllers\AuthController:logout");

// AJAX endpoints
$app->get("/ajax/random-user", "\App\Controllers\AjaxController:randomUser");
$app->get("/ajax/search-machines", "\App\Controllers\AjaxController:searchMachines");
// AJAX endpoints for editing forms (example)
$app->get("/ajax/user-edit-form", "\App\Controllers\AjaxController:userEditForm");
$app->post("/ajax/user-update", "\App\Controllers\AjaxController:userUpdate");
$app->get("/ajax/machine-edit-form", "\App\Controllers\AjaxController:machineEditForm");
$app->post("/ajax/machine-update", "\App\Controllers\AjaxController:machineUpdate");
$app->post("/ajax/user-delete", "\App\Controllers\AjaxController:userDelete");
$app->post("/ajax/machine-delete", "\App\Controllers\AjaxController:machineDelete");

// Cookie policy route (example)
$app->get("/cookie-policy", function($request,$response,$container){
    $response->set("inner_view","public/cookie_policy.php");
    $response->setTemplate("layout/base.php");
    return $response;
});

// Auth protected
$app->get("/machines/list", "\App\Controllers\MachinesController:list", [$auth]);
$app->get("/machines/detail/{id}", "\App\Controllers\MachinesController:detail", [$auth]);

// Supervisor or Admin
$app->get("/machines/add", "\App\Controllers\MachinesController:addMachine", [$supervisor]);
$app->post("/machines/store", "\App\Controllers\MachinesController:storeMachine", [$supervisor]);
$app->get("/machines/import", "\App\Controllers\MachinesController:importCSV", [$supervisor]);
$app->post("/machines/handleimportcsv", "\App\Controllers\MachinesController:handleImportCSV", [$supervisor]);

$app->get("/incidents/list", "\App\Controllers\IncidentsController:list", [$auth]);
$app->get("/incidents/detail/{id}", "\App\Controllers\IncidentsController:detail", [$auth]);
$app->post("/incidents/updatestatus/{id}", "\App\Controllers\IncidentsController:updateStatus", [$technician]);
$app->get("/incidents/assignself/{id}", "\App\Controllers\IncidentsController:assignToSelf", [$technician]);

$app->get("/maintenance/list", "\App\Controllers\MaintenanceController:list", [$auth]);
$app->get("/maintenance/add", "\App\Controllers\MaintenanceController:add", [$technician]);
$app->post("/maintenance/store", "\App\Controllers\MaintenanceController:store", [$technician]);
$app->get("/maintenance/downloadpdf/{id}", "\App\Controllers\MaintenanceController:downloadPDF", [$auth]);

// Admin
$app->get("/users/list", "\App\Controllers\UsersController:list", [$admin]);
$app->get("/users/add", "\App\Controllers\UsersController:addUser", [$admin]);
$app->post("/users/store", "\App\Controllers\UsersController:storeUser", [$admin]);

// Logged in user profile
$app->get("/users/profile", "\App\Controllers\UsersController:profile", [$auth]);
$app->post("/users/update-profile", "\App\Controllers\UsersController:updateProfile", [$auth]);

$app->execute();