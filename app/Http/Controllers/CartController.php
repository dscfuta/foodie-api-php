<?php

namespace App\Http\Controllers;

use App\Recipe;
use App\User;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function getUserCart()
    {
        $user = User::find(auth()->user()->id);
        $userCart = $user->cart;

        if ($userCart) {
            $recipes_id = explode(',', $userCart->recipes_id);
            $recipes = [];
            if ($recipes_id) {
                foreach ($recipes_id as $id) {
                    if ($id) {
                        $recipe = Recipe::find($id);
                        array_push($recipes, $recipe);
                    }
                }
            }
            $userCart->recipes = $recipes;

            return JsonRes(SUCCESS_CODE, ['cart' => $userCart], 'Success');
        } else {
            return JsonRes(NOT_FOUND_CODE, [], 'Cart Not Found');
        }
    }

    public function addToCart($recipe_id)
    {
        $recipe = Recipe::find($recipe_id);

        if ($recipe) {
            $user = User::find(auth()->user()->id);
            $user_recipes = explode(',', $user->cart->recipes_id);

            array_push($user_recipes, $recipe_id);
            $user->cart->recipes_id = implode(',', $user_recipes);
            $user->cart->save();

            return JsonRes(SUCCESS_CODE, ['cart' => $user->cart], 'Recipe has been Added to your cart');

        } else {
            return JsonRes(NOT_FOUND_CODE, [], 'Recipe Not Found');
        }
    }

    public function removeFromCart($recipe_id)
    {
        $user = User::find(auth()->user()->id);
        $user_recipes = explode(',', $user->cart->recipes_id);

        $user_recipes = array_diff($user_recipes, [$recipe_id]);
        $user->cart->recipes_id = implode(',', $user_recipes);
        $user->cart->save();
        $userCart = $user->cart;

        if ($userCart) {
            $recipes_id = explode(',', $userCart->recipes_id);
            $recipes = [];
            if ($recipes_id) {
                foreach ($recipes_id as $id) {
                    if ($id) {
                        $recipe = Recipe::find($id);
                        array_push($recipes, $recipe);
                    }
                }
            }
            $userCart->recipes = $recipes;

            return JsonRes(SUCCESS_CODE, ['cart' => $user->cart], 'Recipe has been removed from your cart');
        } else {
            return JsonRes(SUCCESS_CODE, [], 'Recipe has been removed from your cart');
        }

    }
}
