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

Route::prefix('admin')->group(function () {
    Route::get('sign-in', [\Modules\Admin\Http\Controllers\AuthController::class, 'login'])->name('admin.login.index');
    Route::post('sign-in', [\Modules\Admin\Http\Controllers\AuthController::class, 'postLogin'])->name('admin.login.action');
//    Route::get('sign-up', [\Modules\Admin\Http\Controllers\AuthController::class, 'register'])->name('admin.register.index');
//    Route::post('sign-up', [\Modules\Admin\Http\Controllers\AuthController::class, 'postRegister'])->name('admin.register.store');
//    Route::get('/register-success', [\Modules\Admin\Http\Controllers\AuthController::class, 'registerSuccess'])->name('admin.register.success');
//    Route::get('/email-verify/{id}/{hash}', [\Modules\Admin\Http\Controllers\AuthController::class, 'verifyEmail'])->name('admin.verification.verify');


    Route::middleware('admin')->group(function () {

        Route::get('sign-out', [\Modules\Admin\Http\Controllers\AuthController::class, 'logOut'])->name('admin.logout');

        Route::prefix('user')->group(function () {
            Route::get('/', [\Modules\Admin\Http\Controllers\UserController::class, 'listChoose'])->name('admin.user.list');
            Route::get('/choose/{id}', [\Modules\Admin\Http\Controllers\UserController::class, 'choose'])->name('admin.user.choose');
            Route::get('/active', [\Modules\Admin\Http\Controllers\UserController::class, 'active'])->name('admin.user.active');
        });

        if (!empty($_SESSION["admin_choose_user_id"])) {
            $userId = $_SESSION["admin_choose_user_id"];
        } else {
            $_SESSION["admin_choose_user_id"] = "";
            $userId = "";
        }

        Route::prefix("user/" . $userId)->group(function () {
            Route::middleware('admin_user_choose')->group(function () {
                Route::middleware('admin_project_active')->group(function () {
                    Route::middleware('admin_project_check')->group(function () {
                        Route::prefix('task')->group(function () {
                            Route::get('/', [\Modules\Admin\Http\Controllers\TaskController::class, 'index'])->name('admin.task.index');
                            Route::get('/create', [\Modules\Admin\Http\Controllers\TaskController::class, 'create'])->name('admin.task.create');
                            Route::post('/create', [\Modules\Admin\Http\Controllers\TaskController::class, 'store'])->name('admin.task.create');
                            Route::get('/show/{id}', [\Modules\Admin\Http\Controllers\TaskController::class, 'show'])->name('admin.task.show');
                            Route::get('/edit/{id}', [\Modules\Admin\Http\Controllers\TaskController::class, 'edit'])->name('admin.task.edit');
                            Route::post('/edit/{id}', [\Modules\Admin\Http\Controllers\TaskController::class, 'update'])->name('admin.task.edit');
                            Route::post('/update-status', [\Modules\Admin\Http\Controllers\TaskController::class, 'updateStatus'])->name('admin.task.update.status');
                        });

                        Route::prefix('kanban')->group(function () {
                            Route::get('/board', [\Modules\Admin\Http\Controllers\KanbanController::class, 'board'])->name('admin.kanban.board');
                        });
                    });

                    Route::prefix('project')->group(function () {
                        Route::get('/', [\Modules\Admin\Http\Controllers\ProjectController::class, 'index'])->name('admin.project.index');
                        Route::get('/create', [\Modules\Admin\Http\Controllers\ProjectController::class, 'create'])->name('admin.project.create');
                        Route::post('/create', [\Modules\Admin\Http\Controllers\ProjectController::class, 'store'])->name('admin.project.create');
                        Route::get('/show/{id}', [\Modules\Admin\Http\Controllers\ProjectController::class, 'show'])->name('admin.project.show');
                        Route::get('/edit/{id}', [\Modules\Admin\Http\Controllers\ProjectController::class, 'edit'])->name('admin.project.edit');
                        Route::post('/edit/{id}', [\Modules\Admin\Http\Controllers\ProjectController::class, 'update'])->name('admin.project.edit');
                        Route::post('/permission/check-email', [\Modules\Admin\Http\Controllers\ProjectController::class, 'checkEmail'])->name('admin.project.check.permission.email');
                        Route::post('/active-user', [\Modules\Admin\Http\Controllers\ProjectController::class, 'activeUser'])->name('admin.project.active.user');
                    });

                    Route::prefix('chart')->group(function () {
                        Route::get('/gantt', [\Modules\Admin\Http\Controllers\ChartController::class, 'gantt'])->name('admin.chart.gantt');
                    });

                });
            });
        });

//        Route::prefix('my-page')->group(function () {
//            Route::get('/', [\Modules\Admin\Http\Controllers\AdminController::class, 'show'])->name('admin.mypage.show');
//            Route::get('/edit', [\Modules\Admin\Http\Controllers\AdminController::class, 'edit'])->name('admin.mypage.edit');
//            Route::post('/edit', [\Modules\Admin\Http\Controllers\AdminController::class, 'update']);
//        });

        Route::prefix('my-page')->group(function () {
            Route::get('/', [\Modules\Admin\Http\Controllers\UserController::class, 'show'])->name('admin.mypage.show');
            Route::get('/edit', [\Modules\Admin\Http\Controllers\UserController::class, 'edit'])->name('admin.mypage.edit');
            Route::post('/edit', [\Modules\Admin\Http\Controllers\UserController::class, 'update']);
        });

        Route::prefix('permission')->group(function () {
            Route::get('/', [\Modules\Admin\Http\Controllers\PermissionController::class, 'index']);
            Route::get('/', [\Modules\Admin\Http\Controllers\PermissionController::class, 'index'])->name('admin.permission.index');
            Route::get('/create', [\Modules\Admin\Http\Controllers\PermissionController::class, 'create'])->name('admin.permission.create');
            Route::post('/create', [\Modules\Admin\Http\Controllers\PermissionController::class, 'store']);
            Route::get('/show/{id}', [\Modules\Admin\Http\Controllers\PermissionController::class, 'show'])->name('admin.permission.show');
            Route::get('/edit/{id}', [\Modules\Admin\Http\Controllers\PermissionController::class, 'edit'])->name('admin.permission.edit');
            Route::post('/edit/{id}', [\Modules\Admin\Http\Controllers\PermissionController::class, 'update']);
        });

    });

});
