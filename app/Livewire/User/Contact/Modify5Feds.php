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
use Livewire\Component;

class Modify5Feds extends Component
{
    public string $federationId;

    public $federation;

    public string $userId;

    public $userContact;

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
    public function mount(string $fid, ?string $uid = '') // route()
    {
        // 1. check input
        $this->federationId = $fid;
        $this->federation = Federation::findOrFail($fid);

        $uid = ($uid === '') ? Auth::id() : $uid;
        $this->userId = $uid;
        $this->userContact = UserContact::where('user_id', $this->userId)->get();

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
                ->where('user_contact_user_id', $uid)
                ->where('federation_id', $fid)
                ->where('field_name', $definition->field_name)
                ->first();
            $this->formData[$definition->field_name] = ($value) ? $value->field_value : '';
        }

        // maintain array, not collection
        // here array keys
        ds($this->fieldDefinitions);
        $this->formFieldSet = array_values(collect($this->fieldDefinitions)->toArray());
        ds($this->formFieldSet);
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
     * @return void
     */
    public function rules()
    {
        $rulesSet = [];
        foreach ($this->formFieldSet as $f) {
            $rulesSet['formData.'.$f['fieldName']] = 'sometimes|'.$f['field_validation_rules'];
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
        ds(__FUNCTION__);
        $validated = $this->validate();
        // not the best but... for few record acceptable
        foreach ($validated['formData'] as $key => $value) {
            ds('KV: '.$key.' / '.$value);
            foreach ($this->formFieldSet as $field) {
                ds('check ff:'.$field['fieldName']);
                if ($field['fieldName'] === $key) {
                    ds('for: '.$key.' val:'.$field['field_default_value'].' vs. '.$value);
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
