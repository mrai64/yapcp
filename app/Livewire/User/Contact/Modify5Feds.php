<?php

/**
 * That component manage a dynamic form based on fields definition
 * tabled in federation_mores
 * TODO put default value in placeholder field, and real value in field wire:
 *
 * Note: some var names seems not PSR-12 compliant but i.e.
 * field_name is direct from table query so i need mantain it
 * named field_name instead of fieldName,
 *
 * @see /resources/views/livewire/user/contact/modify5-feds.blade.php
 *
 */

namespace App\Livewire\User\Contact;

use App\Models\Federation;
use App\Models\FederationMore;
use App\Models\UserContact;
use App\Models\UserContactMore;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Livewire\Component;

class Modify5Feds extends Component
{
    public string $federationId;

    public Federation $federation;

    public string $userId;

    public UserContact $userContact;

    public array $formData = [];

    public $fieldDefinitions;

    public array $formFieldSet = [];

    // 1. mount()
    /**
     * Mount pick and prepare datas for view, with 2 params
     * first is federation id, second should be a user contact id
     * but if missing is assumed logged user contact id.
     *
     * @param string $fid
     * @param string|null $uid
     * @return void
     */
    public function mount(Federation $federation, ?UserContact $userContact = null) // route()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        if ($userContact === null) {
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' no parm');
            $uid = Auth::id(); // user id
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' uid: ' . $uid);
            $this->userContact = UserContact::where('id', $uid)->first();
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' uC: ' . json_encode($this->userContact));
        } else {
            Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' parm');
            $this->userContact = $userContact;
        }

        // form fields
        $this->firstName = $this->userContact->first_name; // name         readonly
        $this->lastName = $this->userContact->last_name; //   surname      readonly
        // default value ITA as first developer he's italian 
        $this->countryId = ($this->userContact->country_id ?? 'ITA');
        $this->country = $this->userContact->country; //      nationality  readonly

        // 1. check input
        $this->federationId = $federation->id;
        $this->federation = $federation;

        // full list
        $this->fieldDefinitions = FederationMore::select([
            'id',
            'field_name',
            'field_label',
            'field_validation_rules',
            'field_default_value',
            'field_suggest',
        ])
            ->where('federation_id', $this->federationId)
            ->orderBy('field_label')
            ->get();

        // default values | user values for user id
        foreach ($this->fieldDefinitions as $definition) {
            $value = UserContactMore::select('field_value')
                ->where('user_contact_user_id', $userContact->id)
                ->where('federation_id', $federation->id)
                ->where('field_name', $definition->field_name)
                ->first();
            $this->formData[$definition->field_name] = ($value) ? $value->field_value : '';
        }

        // maintain array, not collection
        // here array keys
        $this->formFieldSet = array_values(collect($this->fieldDefinitions)->toArray());
    }

    // 2. render()
    public function render()
    {
        return view('livewire.user.contact.modify5-feds');
    }

    /**
     * 3. validation rules
     *
     * As that are "more" user_contact data, all fields are
     * 'sometimes'
     *
     * @return array
     */
    public function rules()
    {
        $rulesSet = [];
        foreach ($this->formFieldSet as $f) {
            $rulesSet['formData.' . $f['fieldName']] = 'sometimes|' . $f['field_validation_rules'];
        }

        return $rulesSet;
    }

    // 4. validation attributes
    public function attributes()
    {
        $attributes = [];
        foreach ($this->formFieldSet as $f) {
            $attributes['formData.'.$f['fieldName']] = $f['field_label'];
        }

        return $attributes;
    }

    /**
     *  5. validate n update
     *
     * As all fields are not required, when a data is in
     * the input must be updated or created in user_contact_mores
     * But to delete record in user_contact_mores ?
     * delete button for field? Or insert a default value?
     *
     * @return void
     */
    public function updateUserContactMore()
    {
        Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' called');
        $validated = $this->validate();
        // not the best but... for few record acceptable
        foreach ($validated['formData'] as $key => $value) {
         Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' KV: '.$key.' / '.$value);
            foreach ($this->formFieldSet as $field) {
                Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' check ff:'.$field['fieldName']);
                if ($field['fieldName'] === $key) {
                    Log::info('Component ' . __CLASS__ . ' f:' . __FUNCTION__ . ' l:' . __LINE__ . ' for: '.$key.' val:'.$field['field_default_value'].' vs. '.$value);
                    if ($field['field_default_value'] !== $value) {
                        $set = UserContactMore::updateOrCreate(
                            ['user_contact_user_id' => $this->userId, 'federation_id' => $this->federationId, 'field_name' => $key],
                            ['field_value' => $value]
                        );
                    } else {
                        $set = UserContactMore::where('user_contact_user_id', $this->userId)
                            ->where('federation_id', $this->federationId)
                            ->where('field_name', $key)
                            ->delete();
                    }
                }
            }
        }

        session()->flash('success', __('Successful data updated'));
        $this->resetErrorBag();
    }
}
