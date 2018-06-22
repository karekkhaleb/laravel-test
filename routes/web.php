<?php
use Illuminate\Http\Request;
use \App\Product;
use \Illuminate\Support\Facades\Storage;
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

Route::get('/', function () {

    $file = Storage::get('file.json');

    return view('welcome');
});

Route::get('getProducts',function (Request $request){

    $xml = Storage::get('test.json');

//    return response()->json(['students'=>['caleb','claude','eben']]);
    return response()->json($xml);
});


Route::post('createProduct',function (Request $request){
//    return response()->json(['name' => 'Abigail', 'state' => 'CA'],200);
    $newProduct = new Product();
    $newProduct->products = $request->all();
//    return $request->all();

//    return response()->json($request);
    Storage::put('test.json', $newProduct);

    return response()->json(Storage::get('test.json'));
//    return response()->json($request->all());


    return 'do me a favor';
});