<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MatochucUniqueIfIdTochuchoptacNull implements Rule
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
        $id_tochuchoptac = request()->input('tochuchoptac.id_tochuchoptac');

        // Kiểm tra nếu giá trị của 'id_tochuchoptac' là null, thì mới kiểm tra tính duy nhất của 'matochuc'
        if ($id_tochuchoptac == null) {
            // Kiểm tra tính duy nhất của 'matochuc' khi 'id_tochuchoptac' là null
            return !DB::table('d_m_to_chucs')
                ->where('tentochuc', $value)
                ->exists();
        }

        // Trả về true để bỏ qua quy tắc nếu 'id_donvi' không phải là null
        return true;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return 'Tổ chức hợp tác kê khai đã tồn tại trên hệ thống.';
    }
}
