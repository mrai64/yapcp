<?php

/**
 * That component manage a dynamic form based on fields definition
 * tabled in federation_mores
 * TODO put default value in placeholder field, and real value in field wire:
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
    public string $federation_id;

    public $federation;

    public string $user_contact_user_id;

    public $user_contact;

    public array $formData = [];

    public $fieldDefinitions;

    public array $formField = [];

    // 1. mount()
    public function mount(string $fid, ?string $uid = '') // route()
    {
        // 1. check input
        $this->federation_id = $fid;
        $this->federation = Federation::findOrFail($fid);

        $uid = ($uid === '') ? Auth::id() : $uid;
        $this->user_contact_user_id = $uid;
        $this->user_contact = UserContact::where('user_id', $this->user_contact_user_id)->get();

        // full list
        $this->fieldDefinitions = FederationMore::select([
            'id',
            'field_name',
            'field_label',
            'field_validation_rules',
            'field_default_value',
            'field_suggest',
        ])
            ->where('federation_id', $this->federation_id)
            ->orderBy('field_label')->get();

        // default values | user values
        foreach ($this->fieldDefinitions as $definition) {
            $value = UserContactMore::select('field_value')
                ->where('user_contact_user_id', $uid)
                ->where('federation_id', $fid)
                ->where('field_name', $definition->field_name)
                ->first();
            $this->formData[$definition->field_name] = ($value) ? $value->field_value : '';
        }

        // maintain array, not collection
        $this->formField = array_values(collect($this->fieldDefinitions)->toArray());
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
        $rules_array = [];
        foreach ($this->formField as $f) {
            $rules_array['formData.'.$f['field_name']] = 'sometimes|'.$f['field_validation_rules'];
        }

        return $rules_array;
    }

    // 4. validation attributes
    public function attributes()
    {
        $attributes = [];
        foreach ($this->formField as $f) {
            $attributes['formData.'.$f['field_name']] = $f['field_label'];
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
        $validated = $validated['formData'];
        // not the best but... for few record acceptable
        foreach ($validated as $key => $value) {
            ds('KV: '.$key.' / '.$value);
            foreach ($this->formField as $field) {
                ds('check ff:'.$field['field_name']);
                if ($field['field_name'] === $key) {
                    ds('for: '.$key.' val:'.$field['field_default_value'].' vs. '.$value);
                    if ($field['field_default_value'] !== $value) {
                        $set = UserContactMore::updateOrCreate(
                            ['user_contact_user_id' => $this->user_contact_user_id, 'federation_id' => $this->federation_id, 'field_name' => $key],
                            ['field_value' => $value]
                        );
                    } else {
                        $set = UserContactMore::where('user_contact_user_id', $this->user_contact_user_id)->where('federation_id', $this->federation_id)->where('field_name', $key)->delete();
                    }
                }
            }
        }

        session()->flash('success', __('Successful data updated'));
        $this->resetErrorBag();
    }
}
