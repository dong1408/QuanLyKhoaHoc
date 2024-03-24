<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class NameUniqueIfIdTapchiNull implements Rule
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
        $id_tapchi = request()->input('tapchi.id_tapchi');
        if ($id_tapchi == null) {
            return !DB::table('tap_chis')
                ->where('name', $value)
                ->exists();
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
        return 'Trường :attribute của tạp chí kê khai đã tồn tại trên hệ thống.';
    }
}
