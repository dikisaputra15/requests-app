<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\RequesttypeController;
use App\Http\Controllers\RequestController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\InfrastructureController;
use App\Http\Controllers\NetworkController;
use App\Http\Controllers\ArchitectureController;
use App\Http\Controllers\DevsecopsController;
use App\Http\Controllers\DbadministratorController;

Route::get('/', function () {
    return view('auth.login');
});

Route::get('home', [DashboardController::class, 'index'])->name('home')->middleware(['auth']);
Route::resource('roles', RoleController::class)->middleware(['auth']);
Route::resource('requesttypes', RequesttypeController::class)->middleware(['auth']);
Route::resource('users', UserController::class)->middleware(['auth']);
Route::post('/users/{user}/update-role', [UserController::class, 'updateRole'])->name('users.updateRole')->middleware(['auth']);
Route::resource('infrastructure-complated', InfrastructureController::class)->middleware(['auth']);
Route::get('infrastructure-onprogress', [InfrastructureController::class, 'onprogress'])->middleware(['auth']);
Route::get('infrastructure-available', [InfrastructureController::class, 'available'])->middleware(['auth']);
Route::get('network-completed', [NetworkController::class, 'reqcompleted'])->middleware(['auth']);
Route::get('network-onprogress', [NetworkController::class, 'reqonprogress'])->middleware(['auth']);
Route::get('network-available', [NetworkController::class, 'reqavailable'])->middleware(['auth']);
Route::get('architecture-completed', [ArchitectureController::class, 'reqcompleted'])->middleware(['auth']);
Route::get('architecture-onprogress', [ArchitectureController::class, 'reqonprogress'])->middleware(['auth']);
Route::get('architecture-available', [ArchitectureController::class, 'reqavailable'])->middleware(['auth']);
Route::get('devsecops-available', [DevsecopsController::class, 'reqavailable'])->middleware(['auth']);
Route::get('devsecops-onprogress', [DevsecopsController::class, 'reqonprogress'])->middleware(['auth']);
Route::get('devsecops-completed', [DevsecopsController::class, 'reqcompleted'])->middleware(['auth']);
Route::get('dbadministrator-completed', [DbadministratorController::class, 'reqcompleted'])->middleware(['auth']);
Route::get('dbadministrator-onprogress', [DbadministratorController::class, 'reqonprogress'])->middleware(['auth']);
Route::get('dbadministrator-available', [DbadministratorController::class, 'reqavailable'])->middleware(['auth']);
Route::get('form-spec-upgrade', [InfrastructureController::class, 'formspecup'])->middleware(['auth']);
Route::get('form-soft-install', [InfrastructureController::class, 'formsoftinstall'])->middleware(['auth']);
Route::get('form-address-ip', [NetworkController::class, 'formaddressip'])->middleware(['auth']);
Route::get('form-firewall-access', [NetworkController::class, 'formfirewallaccess'])->middleware(['auth']);
Route::get('form-review-arch', [ArchitectureController::class, 'formreviewarch'])->middleware(['auth']);
Route::get('form-doc-arch', [ArchitectureController::class, 'formdocarch'])->middleware(['auth']);
Route::get('form-sec-scan', [DevsecopsController::class, 'formsecscan'])->middleware(['auth']);
Route::get('form-prod-merge', [DevsecopsController::class, 'formprodmerge'])->middleware(['auth']);
Route::get('form-query-exec', [DbadministratorController::class, 'formqueryexec'])->middleware(['auth']);
Route::get('form-data-retrieval', [DbadministratorController::class, 'formdataretrieval'])->middleware(['auth']);
Route::get('developer-request-complated', [RequestController::class, 'reqcomplated'])->middleware(['auth']);
Route::get('developer-request-onprogress', [RequestController::class, 'reqonprogress'])->middleware(['auth']);
Route::get('developer-request-onprogress/{id}/detail', [RequestController::class, 'devdetailonprogress'])->middleware(['auth']);
Route::post('proses-formspec', [InfrastructureController::class, 'saveformspec'])->middleware(['auth']);
Route::post('proses-formsoft', [InfrastructureController::class, 'saveformsoft'])->middleware(['auth']);
Route::post('proses-formipaddress', [NetworkController::class, 'saveformipaddress'])->middleware(['auth']);
Route::post('proses-formfirewall', [NetworkController::class, 'saveformfirewall'])->middleware(['auth']);
Route::post('proses-formreview', [ArchitectureController::class, 'saveformreview'])->middleware(['auth']);
Route::post('proses-formdoc', [ArchitectureController::class, 'saveformdoc'])->middleware(['auth']);
Route::post('proses-formsecscan', [DevsecopsController::class, 'saveformsecscan'])->middleware(['auth']);
Route::post('proses-formprodmerge', [DevsecopsController::class, 'saveformprodmerge'])->middleware(['auth']);
Route::post('proses-formqueryex', [DbadministratorController::class, 'saveformqueryex'])->middleware(['auth']);
Route::post('proses-formdataret', [DbadministratorController::class, 'saveformdataret'])->middleware(['auth']);
Route::get('agent-request-available', [RequestController::class, 'agentreqavailable'])->middleware(['auth']);
Route::get('agent-request-onprogress', [RequestController::class, 'agentreqonprogress'])->middleware(['auth']);
Route::get('agent-request-complated', [RequestController::class, 'agentreqcomplated'])->middleware(['auth']);
Route::get('agent-request-available/{id}/asign', [RequestController::class, 'agentasignreq'])->middleware(['auth']);
Route::get('agent-request-onprogress/{id}/detail', [RequestController::class, 'agentdetailonprogress'])->middleware(['auth']);
Route::get('agent-request-available/{id}/detail', [RequestController::class, 'agentdetailavailable'])->middleware(['auth']);

