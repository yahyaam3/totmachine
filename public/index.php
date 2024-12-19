<?php

// Autoload dependencies
include "../vendor/autoload.php";

// Define the container with configuration
$contenidor = new \App\Container(__DIR__ . "/../App/config.php");

// Initialize the application instance
$app = new \Emeset\Emeset($contenidor);

// Middleware Instances
$auth = new \App\Middleware\AuthMiddleware();
$supervisor = new \App\Middleware\SupervisorMiddleware();
$technician = new \App\Middleware\TechnicianMiddleware();
$admin = new \App\Middleware\AdminMiddleware();

// Public Routes (accessible by visitors)
$app->get("/", "\App\Controllers\PublicController:index");
$app->get("/public/register-incident", "\App\Controllers\PublicController:registerIncidentPublic");
$app->post("/public/store-incident", "\App\Controllers\PublicController:storeIncidentPublic");

// Authentication Routes
$app->get("/login", "\App\Controllers\AuthController:showLogin");
$app->post("/login", "\App\Controllers\AuthController:login");
$app->get("/logout", "\App\Controllers\AuthController:logout");

// Password Recovery Routes
$app->get("/forgot-password", "\App\Controllers\AuthController:showForgotPassword");
$app->post("/forgot-password", "\App\Controllers\AuthController:forgotPassword");
$app->get("/reset-password", "\App\Controllers\AuthController:showResetPassword");
$app->post("/reset-password", "\App\Controllers\AuthController:resetPassword");

// AJAX Routes for various actions
$app->get("/ajax/random-user", "\App\Controllers\AjaxController:randomUser");
$app->get("/ajax/search-machines", "\App\Controllers\AjaxController:searchMachines");

// AJAX Routes
$app->get("/ajax/user-edit-form", "\App\Controllers\AjaxController:userEditForm", [$auth]);
$app->post("/ajax/user-update", "\App\Controllers\AjaxController:userUpdate", [$auth]);
$app->post("/ajax/user-delete", "\App\Controllers\AjaxController:userDelete", [$auth]);

$app->get("/ajax/machine-edit-form", "\App\Controllers\AjaxController:machineEditForm", [$auth]);
$app->post("/ajax/machine-update", "\App\Controllers\AjaxController:machineUpdate", [$auth]);
$app->post("/ajax/machine-delete", "\App\Controllers\AjaxController:machineDelete", [$auth]);
$app->get("/ajax/machine-add-form", "\App\Controllers\AjaxController:machineAddForm", [$auth]);
$app->post("/ajax/machine-store", "\App\Controllers\AjaxController:machineStore", [$auth]);

$app->get("/ajax/incident-edit-form", "\App\Controllers\AjaxController:incidentEditForm", [$auth]);
$app->post("/ajax/incident-update", "\App\Controllers\AjaxController:incidentUpdate", [$auth]);
$app->post("/ajax/incident-delete", "\App\Controllers\AjaxController:incidentDelete", [$auth]);

$app->get("/ajax/maintenance-edit-form", "\App\Controllers\AjaxController:maintenanceEditForm", [$auth]);
$app->post("/ajax/maintenance-update", "\App\Controllers\AjaxController:maintenanceUpdate", [$auth]);
$app->post("/ajax/maintenance-delete", "\App\Controllers\AjaxController:maintenanceDelete", [$auth]);

// AJAX routes for add forms
$app->get("/ajax/maintenance-add-form", "\App\Controllers\AjaxController:maintenanceAddForm", [$auth]);
$app->post("/ajax/maintenance-store", "\App\Controllers\AjaxController:maintenanceStore", [$auth]);
$app->get("/ajax/user-add-form", "\App\Controllers\AjaxController:userAddForm", [$auth]);
$app->post("/ajax/user-store", "\App\Controllers\AjaxController:userStore", [$auth]);

// AJAX routes for delete operations
$app->post("/ajax/user-delete", "\App\Controllers\AjaxController:userDelete", [$auth]);
$app->post("/ajax/machine-delete", "\App\Controllers\AjaxController:machineDelete", [$auth]);
$app->post("/ajax/incident-delete", "\App\Controllers\AjaxController:incidentDelete", [$auth]);
$app->post("/ajax/maintenance-delete", "\App\Controllers\AjaxController:maintenanceDelete", [$auth]);

// Cookie Policy Route (info about cookies)
$app->get("/cookie-policy", function($request, $response, $container) {
    $response->set("inner_view", "public/cookie_policy.php");
    $response->setTemplate("layout/base.php");
    return $response;
});

// Authenticated Routes (accessible by authenticated users)
$app->get("/machines/list", "\App\Controllers\MachinesController:list", [$auth]);
$app->get("/machines/detail/{id}", "\App\Controllers\MachinesController:detail", [$auth]);

// Routes for Supervisor and Admin (can add, store, and import machines)
$app->get("/machines/add", "\App\Controllers\MachinesController:addMachine", [$supervisor]);
$app->post("/machines/store", "\App\Controllers\MachinesController:storeMachine", [$supervisor]);
$app->get("/machines/import", "\App\Controllers\MachinesController:importCSV", [$supervisor]);
$app->post("/machines/handleimportcsv", "\App\Controllers\MachinesController:handleImportCSV", [$supervisor]);

// Incident Routes (only authenticated users can list, view and update incidents)
$app->get("/incidents/list", "\App\Controllers\IncidentsController:list", [$auth]);
$app->get("/incidents/detail/{id}", "\App\Controllers\IncidentsController:detail", [$auth]);
$app->post("/incidents/updatestatus/{id}", "\App\Controllers\IncidentsController:updateStatus", [$technician]);
$app->get("/incidents/assignself/{id}", "\App\Controllers\IncidentsController:assignToSelf", [$technician]);

// Route for assigning an incident to a technician (only Supervisor or Admin can do this)
$app->post("/incidents/assign", "\App\Controllers\IncidentsController:assign", [$supervisor]);

// Maintenance Routes (only authenticated users can view maintenance, technicians can add and store maintenance)
$app->get("/maintenance/list", "\App\Controllers\MaintenanceController:list", [$auth]);
$app->get("/maintenance/add", "\App\Controllers\MaintenanceController:add", [$technician]);
$app->post("/maintenance/store", "\App\Controllers\MaintenanceController:store", [$technician]);
$app->get("/maintenance/downloadpdf/{id}", "\App\Controllers\MaintenanceController:downloadPDF", [$auth]);

// Admin Routes (only for admin to manage users)
$app->get("/users/list", "\App\Controllers\UsersController:list", [$admin]);
$app->get("/users/add", "\App\Controllers\UsersController:addUser", [$admin]);
$app->post("/users/store", "\App\Controllers\UsersController:storeUser", [$admin]);

// User Profile Routes (allow authenticated users to view and update their profile)
$app->get("/users/profile", "\App\Controllers\UsersController:profile", [$auth]);
$app->post("/users/update-profile", "\App\Controllers\UsersController:updateProfile", [$auth]);

// Technical routes
$app->get("/machines/unassigned", "\App\Controllers\MachinesController:listUnassigned", [$technician]);
$app->post("/machines/self-assign", "\App\Controllers\MachinesController:assignToSelf", [$technician]);
$app->get("/maintenance/scheduled", "\App\Controllers\MaintenanceController:listScheduled", [$technician]);

// Supervisor routes
$app->post("/maintenance/schedule-preventive", "\App\Controllers\MaintenanceController:schedulePreventiveMaintenance", [$supervisor]);

// Execute the application
$app->execute();
