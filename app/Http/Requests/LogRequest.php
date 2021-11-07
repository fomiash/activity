<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use DateTimeInterface;
use DateTime;

class LogRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @param Request $request
     * @return bool
     */
    public function authorize(Request $request)
    {
        // ?_token=6f5aff1c600e8f16f6126b9403c2d6eb4e49cb2814b96f48ba2aa1e7b2703366
        return $request->get('_token') === md5('key1:salt') . md5('key2:salt');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @param Request $request
     * @return array
     */
    public function rules(Request $request) {
        return [];
    }
}


