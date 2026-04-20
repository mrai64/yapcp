<?php

namespace App\Http\Requests;

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
        $examine = $user->isAdmin();
        ds('FormRequest: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' rc:' . $examine);
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
        ds('FormRequest: ' . __CLASS__ . ' ' . __FUNCTION__ . ' line:' . __LINE__ . ' called');
        return [
            'federationId' => 'required|string|uppercase|min:3|max:10|unique:federations,id', //  id
            'federationName' => 'required|string|min:3|max:255', //                               name_en
            'countryId' => 'required|string|uppercase|min:3|exists:countries,id', //              country_id
            'website' => 'string|active_url|max:255',
            'contactInfo' => 'string', //                                                         contact_info
        ];
    }
}
