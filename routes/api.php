<?php

use App\Http\Controllers\Users\Create;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::post('/register', Create::class);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/vulnerable', function (Request $request) {
    //valida query param "auth"
    $valid = vulnerableValidate($request);

    //se está inválido, retorna mensagem de erro
    if(!$valid){
        return ["error" => $valid];
    }
    
    //se está válido, retorna dados
    return ["teste" => 1];
});

Route::get('/vulnerable-fix', function (Request $request) {
    //valida query param "auth"
    $validData = fixValidate($request);

    //se está inválido, retorna mensagem de erro
    if(!$validData["is_valid"]){
        return ["error" => $validData["message"]];
    }
    
    //se está válido, retorna dados
    return ["teste" => 1];
});

function vulnerableValidate(Request $request)
{
    //verifica se query param "auth" é "123" e retorna true
    if($request->get("auth") == "123") {
        return true;
    }

    //retorna mensagem de erro
    return "Token Inválido";
}

function fixValidate(Request $request): array
{
    //funcao retorna sempre o mesmo tipo "array associativo"
    //cada index do array retorna sempre o mesmo tipo
    if($request->get("auth") != "123") {
        return [
            "is_valid" => false,
            "message"  => "Token Inválido"
        ];
    }

    return [
        "is_valid" => true,
        "message"  => ""
    ];
}