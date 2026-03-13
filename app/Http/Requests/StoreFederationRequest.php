<?php

namespace App\Http\Requests;

use App\Models\UserRole;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class StoreFederationRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     * User is authorized when is in admin group, today
     * user_id is picked by Auth
     */
    public function authorize(): bool
    {
        ds('Policy: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        $examine = UserRole::isAdmin();
        // log
        return $examine;
    }

    /**
     * Get the validation rules that apply to the request.
     * apply to /resources/view/federations/add.blade.php
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|string|uppercase|min:3|max:10|unique:federations,id',
            'name_en' => 'required|string|min:3|max:255',
            'country_id' => 'required|string|uppercase|min:3|exists:countries,id',
            'website' => 'string|active_url|max:255',
            'contact_info' => 'string',
        ];
    }
}
