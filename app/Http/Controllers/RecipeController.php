<?php

namespace App\Http\Controllers;

use App\Recipe;
use Illuminate\Http\Request;
use Psy\Util\Json;

class RecipeController extends Controller
{
    public function getAll(Request $request){
        $recipes = Recipe::all();

        if ($recipes){
            return JsonRes(SUCCESS_CODE, ['recipes' => $recipes], 'Success');
        } else{
            return JsonRes(NOT_FOUND_CODE, [], 'Not Found');
        }
    }

    public function getOne(Request $request){
        $recipe = Recipe::find($request->id);

        if ($recipe){
            $recipe['vendor'] = $recipe->vendor;
            return JsonRes(SUCCESS_CODE, ['recipe' => $recipe], 'Success');
        } else{
            return JsonRes(NOT_FOUND_CODE, [], 'Not Found');
        }

    }
}
