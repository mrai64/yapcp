<?php

/**
 * English is base
 * but not the only
 * see also <https://www.w3.org/International/questions/qa-html-language-declarations>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LangList extends Model
{
    public const lang_list = [
        'en' => 'English',   // also fallback language
        'it' => 'Italian *', // \*: incomplete '/resources/lang/it.json'
        // incomplete list

    ];

    // use dir="auto"
    public const rtl_lang_list = [
        'ar', // Arabic
        'he', // Hebrew
        // incomplete list
    ];

    public function __construct()
    {
        return self::lang_list;
    }

    /**
     * @param  string  $lang_code  a language code
     * @return bool true if lang code is in the list
     */
    public function is_lang(string $lang_code): bool
    {
        return array_key_exists(strtolower($lang_code), self::lang_list);
    }

    /**
     * @param  string  $lang_code  a language code
     * @return string ''|'rtl'
     */
    public function is_rtl(string $lang_code): string
    {
        $lang_code = strtolower($lang_code);

        return (in_array($lang_code, self::rtl_lang_list)) ? 'rtl' : '';
    }
}
