<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class RecipeUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            //　バリデーションルール
            'title' => 'required|string|max:50',
            'description' => 'required|string|max:500',
            'category_id' => 'required',
            // バリデーションのrequireは必須になる画像を選択しないとエラーになるため
            //'image' => 'required|file|image|mimes:jpeg,png,jpg,gif|max:2048', 
            'image' => 'file|image|mimes:jpeg,png,jpg,gif|max:2048',
            'ingredients.*.name' => 'required|string|max:50',
            'ingredients.*.quantity' => 'required|string|max:50',
            'steps.*' => 'required|string|max:50'
        ];
    }

    public function attributes()
    {
        // エラーメッセージのカスタマイズ
        return [
            'title' => 'レシピ名',
            'description' => 'レシピの説明',
            'category_id' => 'カテゴリー',
            'image' => '料理の画像',
            'ingredients.*.name' => '材料名',
            'ingredients.*.quantity' => '分量',
            'steps.*' => '手順'
        ];
    }
}
