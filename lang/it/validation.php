<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */

    'accepted' => 'È necessario spuntare il campo :attribute.',
    'accepted_if' => 'È necessario spuntare il campo :attribute quanto :other vale :value.',
    'active_url' => 'Il campo :attribute deve contenere un URL valido.',
    'after' => 'Il campo :attribute deve contenere una data successiva a :date.',
    'after_or_equal' => 'Il campo :attribute deve contenere una data pari o successiva a :date.',
    'alpha' => 'Il campo :attribute può contenere solo caratteri alfabetici.',
    'alpha_dash' => 'Il campo :attribute può contenere solo caratteri alfabetici, cifre, trattini e sottolineature (underscore).',
    'alpha_num' => 'Il campo :attribute può contenere solo caratteri alfabetici e cifre.',
    'any_of' => 'Il contenuto del campo :attribute non va bene.',
    'array' => 'Il contenuto del campo :attribute dev\'essere un array.',
    'ascii' => 'Il contenuto del campo :attribute dev\'essere formato esclusivamente da caratteri alfanumerici mono-byte e simboli.',
    'before' => 'Il contenuto del campo :attribute dev\'essere una data precedente :date.',
    'before_or_equal' => 'Il contenuto del campo :attribute dev\'essere una data pari o precedente :date.',
    'between' => [
        'array' => 'Il contenuto del campo :attribute dev\'essere formato da un insieme di elementi tra i :min e i :max.',
        'file' => 'Il file nel campo :attribute dev\'essere compreso tra :min e :max kilobyte.',
        'numeric' => 'Il numero nel campo :attribute dev\'essere compreso tra :min e :max.',
        'string' => 'La scritta nel campo :attribute dev\'essere lunga tra i :min ed i :max caratteri.',
    ],
    'boolean' => 'Il campo :attribute deve contenere solo true oppure false.',
    'can' => 'Nel campo :attribute non è presente un valore valido.',
    'confirmed' => 'Il campo :attribute di conferma non risulta valido.',
    'contains' => 'Nel campo :attribute manca un valore richiesto.',
    'current_password' => 'La password non combacia.',
    'date' => 'Nel campo :attribute non c\'è una data valida.',
    'date_equals' => 'Nel campo :attribute la data dev\'essere pari o maggiore di :date.',
    'date_format' => 'Il campo :attribute deve contenere un valore conforme al formato :format.',
    'decimal' => 'Il campo :attribute deve contenere :decimal cifre decimali.',
    'declined' => 'The :attribute field must be declined.',
    'declined_if' => 'The :attribute field must be declined when :other is :value.',
    'different' => 'I contenuti dei campi :attribute e :other devono essere diversi.',
    'digits' => 'Il campo :attribute deve contenere almeno :digits cifre.',
    'digits_between' => 'Il campo :attribute deve contenere tra le :min e le :max cifre.',
    'dimensions' => 'Il campo :attribute contiene un\'immagine di dimensioni errate.',
    'distinct' => 'Nel campo :attribute c\'è un valore duplicato.',
    'doesnt_contain' => 'Nel campo :attribute non si può inserire nessuno dei seguenti: :values.',
    'doesnt_end_with' => 'Il campo :attribute non può terminare con uno di questi: :values.',
    'doesnt_start_with' => 'Il campo :attribute non può iniziare con nessuno di questi: :values.',
    'email' => 'Nel campo :attribute va inserito un indirizzo di email valido.',
    'ends_with' => 'Il campo :attribute deve terminare con uno di questi: :values.',
    'enum' => 'L\'attributo :attribute selezionato non è valido.',
    'exists' => 'L\'attributo selezionato :attribute non è valido.',
    'extensions' => 'The :attribute field must have one of the following extensions: :values.',
    'file' => 'The :attribute field must be a file.',
    'filled' => 'The :attribute field must have a value.',
    'gt' => [
        'array' => 'The :attribute field must have more than :value items.',
        'file' => 'The :attribute field must be greater than :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than :value.',
        'string' => 'The :attribute field must be greater than :value characters.',
    ],
    'gte' => [
        'array' => 'The :attribute field must have :value items or more.',
        'file' => 'The :attribute field must be greater than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be greater than or equal to :value.',
        'string' => 'The :attribute field must be greater than or equal to :value characters.',
    ],
    'hex_color' => 'The :attribute field must be a valid hexadecimal color.',
    'image' => 'The :attribute field must be an image.',
    'in' => 'The selected :attribute is invalid.',
    'in_array' => 'The :attribute field must exist in :other.',
    'in_array_keys' => 'The :attribute field must contain at least one of the following keys: :values.',
    'integer' => 'The :attribute field must be an integer.',
    'ip' => 'The :attribute field must be a valid IP address.',
    'ipv4' => 'The :attribute field must be a valid IPv4 address.',
    'ipv6' => 'The :attribute field must be a valid IPv6 address.',
    'json' => 'The :attribute field must be a valid JSON string.',
    'list' => 'The :attribute field must be a list.',
    'lowercase' => 'The :attribute field must be lowercase.',
    'lt' => [
        'array' => 'The :attribute field must have less than :value items.',
        'file' => 'The :attribute field must be less than :value kilobytes.',
        'numeric' => 'The :attribute field must be less than :value.',
        'string' => 'The :attribute field must be less than :value characters.',
    ],
    'lte' => [
        'array' => 'The :attribute field must not have more than :value items.',
        'file' => 'The :attribute field must be less than or equal to :value kilobytes.',
        'numeric' => 'The :attribute field must be less than or equal to :value.',
        'string' => 'The :attribute field must be less than or equal to :value characters.',
    ],
    'mac_address' => 'The :attribute field must be a valid MAC address.',
    'max' => [
        'array' => 'The :attribute field must not have more than :max items.',
        'file' => 'The :attribute field must not be greater than :max kilobytes.',
        'numeric' => 'The :attribute field must not be greater than :max.',
        'string' => 'The :attribute field must not be greater than :max characters.',
    ],
    'max_digits' => 'The :attribute field must not have more than :max digits.',
    'mimes' => 'The :attribute field must be a file of type: :values.',
    'mimetypes' => 'The :attribute field must be a file of type: :values.',
    'min' => [
        'array' => 'The :attribute field must have at least :min items.',
        'file' => 'The :attribute field must be at least :min kilobytes.',
        'numeric' => 'The :attribute field must be at least :min.',
        'string' => 'The :attribute field must be at least :min characters.',
    ],
    'min_digits' => 'The :attribute field must have at least :min digits.',
    'missing' => 'The :attribute field must be missing.',
    'missing_if' => 'The :attribute field must be missing when :other is :value.',
    'missing_unless' => 'The :attribute field must be missing unless :other is :value.',
    'missing_with' => 'The :attribute field must be missing when :values is present.',
    'missing_with_all' => 'The :attribute field must be missing when :values are present.',
    'multiple_of' => 'The :attribute field must be a multiple of :value.',
    'not_in' => 'The selected :attribute is invalid.',
    'not_regex' => 'The :attribute field format is invalid.',
    'numeric' => 'The :attribute field must be a number.',
    'password' => [
        'letters' => 'The :attribute field must contain at least one letter.',
        'mixed' => 'The :attribute field must contain at least one uppercase and one lowercase letter.',
        'numbers' => 'The :attribute field must contain at least one number.',
        'symbols' => 'The :attribute field must contain at least one symbol.',
        'uncompromised' => 'The given :attribute has appeared in a data leak. Please choose a different :attribute.',
    ],
    'present' => 'The :attribute field must be present.',
    'present_if' => 'The :attribute field must be present when :other is :value.',
    'present_unless' => 'The :attribute field must be present unless :other is :value.',
    'present_with' => 'The :attribute field must be present when :values is present.',
    'present_with_all' => 'The :attribute field must be present when :values are present.',
    'prohibited' => 'The :attribute field is prohibited.',
    'prohibited_if' => 'The :attribute field is prohibited when :other is :value.',
    'prohibited_if_accepted' => 'The :attribute field is prohibited when :other is accepted.',
    'prohibited_if_declined' => 'The :attribute field is prohibited when :other is declined.',
    'prohibited_unless' => 'The :attribute field is prohibited unless :other is in :values.',
    'prohibits' => 'The :attribute field prohibits :other from being present.',
    'regex' => 'The :attribute field format is invalid.',
    'required' => 'The :attribute field is required.',
    'required_array_keys' => 'The :attribute field must contain entries for: :values.',
    'required_if' => 'The :attribute field is required when :other is :value.',
    'required_if_accepted' => 'The :attribute field is required when :other is accepted.',
    'required_if_declined' => 'The :attribute field is required when :other is declined.',
    'required_unless' => 'The :attribute field is required unless :other is in :values.',
    'required_with' => 'The :attribute field is required when :values is present.',
    'required_with_all' => 'The :attribute field is required when :values are present.',
    'required_without' => 'The :attribute field is required when :values is not present.',
    'required_without_all' => 'The :attribute field is required when none of :values are present.',
    'same' => 'The :attribute field must match :other.',
    'size' => [
        'array' => 'The :attribute field must contain :size items.',
        'file' => 'The :attribute field must be :size kilobytes.',
        'numeric' => 'The :attribute field must be :size.',
        'string' => 'The :attribute field must be :size characters.',
    ],
    'starts_with' => 'The :attribute field must start with one of the following: :values.',
    'string' => 'The :attribute field must be a string.',
    'timezone' => 'The :attribute field must be a valid timezone.',
    'unique' => 'The :attribute has already been taken.',
    'uploaded' => 'The :attribute failed to upload.',
    'uppercase' => 'The :attribute field must be uppercase.',
    'url' => 'The :attribute field must be a valid URL.',
    'ulid' => 'The :attribute field must be a valid ULID.',
    'uuid' => 'The :attribute field must be a valid UUID.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
