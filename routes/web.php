<?php


use App\Http\Controllers\Productcontroller;
use Illuminate\Support\Facades\Route;


Route::controller(Productcontroller::class)->group( function(){
    Route::get('/',"index")->name("Products.Index");
Route::get('products/create',"create")->name("Products.Create");
Route::post('products/store',"store")->name("Products.Store");
Route::get('products/{products}/edit',"edit")->name("Products.Edit");
Route::put('products/{products}',"update")->name("Products.Update");
Route::delete('products/{products}',"delete")->name("Products.Delete");
});
