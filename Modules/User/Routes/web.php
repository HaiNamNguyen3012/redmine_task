<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
//Route::get('/', [\Modules\User\Http\Controllers\HomeController::class, 'index'])->name('user.home');

Route::prefix('user')->group(function () {
    Route::get('sign-in', [\Modules\User\Http\Controllers\AuthController::class, 'login'])->name('user.login.index');
    Route::post('sign-in', [\Modules\User\Http\Controllers\AuthController::class, 'postLogin'])->name('user.login.action');
    Route::get('sign-up', [\Modules\User\Http\Controllers\AuthController::class, 'register'])->name('user.register.index');
    Route::post('sign-up', [\Modules\User\Http\Controllers\AuthController::class, 'postRegister'])->name('user.register.store');
    Route::get('/register-success', [\Modules\User\Http\Controllers\AuthController::class, 'registerSuccess'])->name('user.register.success');
    Route::get('/email-verify/{id}/{hash}', [\Modules\User\Http\Controllers\AuthController::class, 'verifyEmail'])->name('user.verification.verify');
    Route::get('forgot-password', [\Modules\User\Http\Controllers\AuthController::class, 'forgotPass'])->name('user.forgot.pass');
    Route::get('forgot-password-success', [\Modules\User\Http\Controllers\AuthController::class, 'forgotPassSuccess'])->name('user.forgot.pass.success');
    Route::post('forgot-password', [\Modules\User\Http\Controllers\AuthController::class, 'postForgotPass']);
    Route::get('new-password/{id}/{hash}', [\Modules\User\Http\Controllers\AuthController::class, 'getUpdatePass'])->name('user.register.updatePass');
    Route::post('new-password', [\Modules\User\Http\Controllers\AuthController::class, 'postUpdatePass'])->name('user.register.postUpdatePass');


    Route::middleware('user')->group(function () {

        Route::get('sign-out', [\Modules\User\Http\Controllers\AuthController::class, 'logOut'])->name('user.logout');

        Route::middleware('project_active')->group(function () {
            Route::middleware('user_permission_access')->group(function () {
                Route::middleware('project_check')->group(function () {
                    Route::prefix('task')->group(function () {
                        Route::get('/', [\Modules\User\Http\Controllers\TaskController::class, 'index'])->name('user.task.index');
                        Route::get('/create', [\Modules\User\Http\Controllers\TaskController::class, 'create'])->name('user.task.create');
                        Route::post('/create', [\Modules\User\Http\Controllers\TaskController::class, 'store'])->name('user.task.create');
                        Route::get('/show/{id}', [\Modules\User\Http\Controllers\TaskController::class, 'show'])->name('user.task.show');
                        Route::get('/edit/{id}', [\Modules\User\Http\Controllers\TaskController::class, 'edit'])->name('user.task.edit');
                        Route::post('/edit/{id}', [\Modules\User\Http\Controllers\TaskController::class, 'update'])->name('user.task.edit');
                        Route::post('/update-status', [\Modules\User\Http\Controllers\TaskController::class, 'updateStatus'])->name('user.task.update.status');
                    });

                    Route::prefix('kanban')->group(function () {
                        Route::get('/board', [\Modules\User\Http\Controllers\KanbanController::class, 'board'])->name('user.kanban.board');
                    });
                });

                Route::prefix('project')->group(function () {
                    Route::get('/', [\Modules\User\Http\Controllers\ProjectController::class, 'index'])->name('user.project.index');
                    Route::get('/create', [\Modules\User\Http\Controllers\ProjectController::class, 'create'])->name('user.project.create');
                    Route::post('/create', [\Modules\User\Http\Controllers\ProjectController::class, 'store'])->name('user.project.create');
                    Route::get('/show/{id}', [\Modules\User\Http\Controllers\ProjectController::class, 'show'])->name('user.project.show');
                    Route::get('/edit/{id}', [\Modules\User\Http\Controllers\ProjectController::class, 'edit'])->name('user.project.edit');
                    Route::post('/edit/{id}', [\Modules\User\Http\Controllers\ProjectController::class, 'update'])->name('user.project.edit');
                    Route::post('/permission/check-email', [\Modules\User\Http\Controllers\ProjectController::class, 'checkEmail'])->name('user.project.check.permission.email');
                    Route::post('/check-status-name', [\Modules\User\Http\Controllers\ProjectController::class, 'checkStatus'])->name('user.project.check.status');
                    Route::post('/active-user', [\Modules\User\Http\Controllers\ProjectController::class, 'activeUser'])->name('user.project.active.user');
                });

                Route::prefix('chart')->group(function () {
                    Route::get('/gantt', [\Modules\User\Http\Controllers\ChartController::class, 'gantt'])->name('user.chart.gantt');
                });

            });

            Route::prefix('my-page')->group(function () {
                Route::get('/', [\Modules\User\Http\Controllers\UserController::class, 'show'])->name('user.mypage.show');
                Route::get('/edit', [\Modules\User\Http\Controllers\UserController::class, 'edit'])->name('user.mypage.edit');
                Route::post('/edit', [\Modules\User\Http\Controllers\UserController::class, 'update']);
            });

            Route::prefix('plan')->group(function () {
                Route::get('/', [\Modules\User\Http\Controllers\PlanController::class, 'index'])->name('user.plan.index');
                Route::get('/confirm/{id}', [\Modules\User\Http\Controllers\PlanController::class, 'confirm'])->name('user.plan.confirm');
                Route::post('/confirm/{id}', [\Modules\User\Http\Controllers\PlanController::class, 'pay']);
                Route::post('/check_bought/{id}', [\Modules\User\Http\Controllers\PlanController::class, 'checkBought'])->name('user.plan.check.payment');
                Route::post('/change-plan-free/{id}', [\Modules\User\Http\Controllers\PlanController::class, 'changePlanFree'])->name('user.plan.change.free');
                //Route::get('/confirm-plan-free', [\Modules\User\Http\Controllers\PlanController::class, 'planFree'])->name('user.plan.confirm.free');
                Route::get('/success', [\Modules\User\Http\Controllers\PlanController::class, 'planSuccess'])->name('user.plan.confirm.success');
            });

            Route::prefix('card')->group(function () {
                Route::get('/edit', [\Modules\User\Http\Controllers\CardController::class, 'edit'])->name('user.card.edit');
                Route::post('/edit', [\Modules\User\Http\Controllers\CardController::class, 'update']);
            });

        });

        Route::prefix('permission')->group(function () {
            Route::get('/', [\Modules\User\Http\Controllers\PermissionController::class, 'index']);
            Route::get('/', [\Modules\User\Http\Controllers\PermissionController::class, 'index'])->name('user.permission.index');
            Route::get('/create', [\Modules\User\Http\Controllers\PermissionController::class, 'create'])->name('user.permission.create');
            Route::post('/create', [\Modules\User\Http\Controllers\PermissionController::class, 'store']);
            Route::get('/show/{id}', [\Modules\User\Http\Controllers\PermissionController::class, 'show'])->name('user.permission.show');
            Route::get('/edit/{id}', [\Modules\User\Http\Controllers\PermissionController::class, 'edit'])->name('user.permission.edit');
            Route::post('/edit/{id}', [\Modules\User\Http\Controllers\PermissionController::class, 'update']);
        });

    });

});
