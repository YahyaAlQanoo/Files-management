<?php

use App\Http\Controllers\CsvController;
use App\Http\Controllers\ExcelController;
use App\Http\Controllers\JsonController;
use App\Http\Controllers\XmlController;
use Illuminate\Support\Facades\Route;

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
Route::view('/', 'index')->name('index');
Route::prefix('jso')->group(function() {
    Route::get('/', [JsonController::class, 'index'])->name('json.index');
    Route::get('/edit/{id}', [JsonController::class, 'edit'])->name('json.edit');
    Route::get('/destroy/{id}', [JsonController::class, 'destroy'])->name('json.destroy');
    Route::post('/uploadfromlink', [JsonController::class, 'uploadfromlink'])->name('json.uploadfromlink');
    Route::get('/update/{id}', [JsonController::class, 'update'])->name('json.update');
    Route::get('/create', [JsonController::class, 'create'])->name('json.create');
    Route::get('/store', [JsonController::class, 'store'])->name('json.store');
    Route::post('/uploadfile',[JsonController::class, 'uploadfile'])->name('json.uploadfile');
    Route::get('/download',[JsonController::class, 'download'])->name('json.download');


});


Route::name('excel.')->prefix('exce')->group(function () {
    Route::get('/',[ExcelController::class, 'index'])->name('index');
    Route::get('/create',[ExcelController::class, 'create'])->name('create');
    Route::post('/store',[ExcelController::class, 'store'])->name('store');
    Route::get('/edit/{id}',[ExcelController::class, 'edit'])->name('edit');
    Route::get('/update/{id}',[ExcelController::class, 'update'])->name('update');
    Route::get('/delete/{id}',[ExcelController::class, 'delete'])->name('delete');
    
    Route::post('/uploadfile',[ExcelController::class, 'uploadfile'])->name('uploadfile');
    Route::get('/download',[ExcelController::class, 'download'])->name('download');
    
    Route::get('/remove_col/{id}',[ExcelController::class, 'remove_col'])->name('remove_col');
    Route::get('/create_col{id}',[ExcelController::class, 'create_col'])->name('create_col');
    Route::get('/added_col/{id}',[ExcelController::class, 'added_col'])->name('added_col');
    Route::get('/edit_col/{id}',[ExcelController::class, 'edit_col'])->name('edit_col');
    Route::get('/update_col/{id}',[ExcelController::class, 'update_col'])->name('update_col');
    
});

Route::name('csv.')->prefix('cs')->group(function () {
    Route::get('/',[CsvController::class, 'index'])->name('index');
    Route::get('/create',[CsvController::class, 'create'])->name('create');
    Route::post('/store',[CsvController::class, 'store'])->name('store');
    Route::get('/edit/{id}',[CsvController::class, 'edit'])->name('edit');
    Route::get('/update/{id}',[CsvController::class, 'update'])->name('update');
    Route::get('/delete/{id}',[CsvController::class, 'delete'])->name('delete');
    
    Route::post('/uploadfile',[CsvController::class, 'uploadfile'])->name('uploadfile');
    Route::get('/download',[CsvController::class, 'download'])->name('download');
    
    Route::get('/remove_col/{id}',[CsvController::class, 'remove_col'])->name('remove_col');
    Route::get('/create_col{id}',[CsvController::class, 'create_col'])->name('create_col');
    Route::get('/added_col/{id}',[CsvController::class, 'added_col'])->name('added_col');
    Route::get('/edit_col/{id}',[CsvController::class, 'edit_col'])->name('edit_col');
    Route::get('/update_col/{id}',[CsvController::class, 'update_col'])->name('update_col');
    
});


Route::name('xml.')->prefix('xm')->group(function () {
    Route::get('/', [XmlController::class, 'index'])->name('index');
    Route::get('/edit/{id}', [XmlController::class, 'edit'])->name('edit');
    Route::get('/destroy/{id}', [XmlController::class, 'destroy'])->name('destroy');
    Route::get('/download', [XmlController::class, 'download'])->name('download');
    Route::get('/update/{id}', [XmlController::class, 'update'])->name('update');
    Route::get('/create', [XmlController::class, 'create'])->name('create');
    Route::get('/store', [XmlController::class, 'store'])->name('store');
    Route::post('/uploadfromlink', [XmlController::class, 'uploadfromlink'])->name('uploadfromlink');
    Route::post('/uploadfile',[XmlController::class, 'uploadfile'])->name('uploadfile');

});