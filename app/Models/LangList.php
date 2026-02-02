<?php

/**
 * Translation lang in platform UI
 *
 * Note: not table based
 * see also <https://www.w3.org/International/questions/qa-html-language-declarations>
 */

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LangList newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LangList newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|LangList query()
 * @mixin \Eloquent
 */
class LangList extends Model
{
    public const LANGCODES = [
        'en' => 'English',   // also fallback language
        'it' => 'Italian *', // \*: incomplete '/resources/lang/it.json'
        // incomplete list

    ];

    // use dir="auto"
    public const RTLLANGCODES = [
        'ar', // Arabic
        'he', // Hebrew
        // incomplete list
    ];

    public function __construct()
    {
        return self::LANGCODES;
    }

    /**
     * @param  string  $langCode  a language code
     * @return bool true if lang code is in the list
     */
    public function isLang(string $langCode): bool
    {
        return array_key_exists(strtolower($langCode), self::LANGCODES);
    }

    /**
     * @param  string  $langCode  a language code
     * @return string ''|'rtl'
     */
    public function isRtl(string $langCode): string
    {
        $langCode = strtolower($langCode);

        return (in_array($langCode, self::RTLLANGCODES)) ? 'rtl' : '';
    }
}
