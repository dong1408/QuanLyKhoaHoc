<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class EmailUniqueIfIdTacgiaNull implements Rule
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
        $sanphamtacgias = request()->input('sanpham_tacgia');

        foreach ($sanphamtacgias as $sanphamtacgia) {
            if ($sanphamtacgia['id_tacgia'] == null && $sanphamtacgia['email'] == $value) {
                return !DB::table('Users')
                    ->where('email', $value)
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
        return 'Trường :attribute đã tồn tại trên hệ thống.';
    }
}
