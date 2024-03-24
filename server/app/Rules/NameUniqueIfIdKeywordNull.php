<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NameUniqueIfIdKeywordNull implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        $keywords = request()->input('keywords');

        foreach ($keywords as $keyword) {
            if (($keyword['id_keyword'] == null || empty($keyword['id_keyword']))  && $keyword['name'] == $value) {
                return !DB::table('keywords')
                    ->where('name', $value)
                    ->exists();
            }
        }
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'keyword kê khai đã tồn tại trên hệ thống.';
    }
}
