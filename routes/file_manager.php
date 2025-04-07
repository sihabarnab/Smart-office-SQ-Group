<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

//File Management
use App\Http\Controllers\FileManagerController;


Route::group(['middleware' => ['auth','auth2']], function () {

    //----------------------File Manager------------------------------------
    Route::get('/file_manager', [App\Http\Controllers\ModuleController::class, 'file_manager'])->name('file_manager');

    //my drive
    Route::get('/file_manager/my_drive', [FileManagerController::class, 'my_drive'])->name('my_drive');
    Route::post('/file_manager/folder_store', [FileManagerController::class, 'folder_store'])->name('folder_store');
    Route::get('/file_manager/folder_view/{id}', [FileManagerController::class, 'folder_view'])->name('folder_view');
    Route::post('/file_manager/file_store', [FileManagerController::class, 'file_store'])->name('file_store');


    //sub folder and file store
    Route::post('/file_manager/folder_sub_store/{id}', [FileManagerController::class, 'folder_sub_store'])->name('folder_sub_store');
    Route::post('/file_manager/file_sub_store/{id}', [FileManagerController::class, 'file_sub_store'])->name('file_sub_store');
    //Sub Child 
    Route::get('/file_manager/sub_folder_view/{id}', [FileManagerController::class, 'sub_folder_view'])->name('sub_folder_view');
    Route::post('/file_manager/sub_file_store/{id}', [FileManagerController::class, 'sub_file_store'])->name('sub_file_store');

    //Delete
    Route::get('/file_manager/folder_delete/{id}', [FileManagerController::class, 'folder_delete'])->name('folder_delete');
    Route::get('/file_manager/Sub_folder_delete/{sub_folder_id}', [FileManagerController::class, 'Sub_folder_delete'])->name('Sub_folder_delete');
    Route::get('/file_manager/file_delete/{file_id}', [FileManagerController::class, 'file_delete'])->name('file_delete');

    //Dawonload 
    Route::get('/file_manager/file_dawonload/{id}', [FileManagerController::class, 'fileDawonload'])->name('fileDawonload');

    Route::get('/file_manager/send', [FileManagerController::class, 'send'])->name('send');

    //
    Route::get('/file_manager/share_history', [FileManagerController::class, 'share_history'])->name('share_history');
    Route::get('/file_manager/share_history/search', [FileManagerController::class, 'share_history_search'])->name('share_history_search');


});

//Out Auth url
Route::get('/file_manager/{id}/{id2}', [FileManagerController::class, 'FileManagerLogin'])->name('FileManagerLogin');
Route::post('/file_manager/send_file', [FileManagerController::class, 'login_check'])->name('login_check');
Route::get('/file_manager/dawonload/{id}/{share_id}', [FileManagerController::class, 'Dawonload'])->name('Dawonload');
