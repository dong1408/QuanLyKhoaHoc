<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class MatochucUniqueIfIdDonviNull implements Rule
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
        $id_donvi = request()->input('sanpham.donvi.id_donvi');

        // Kiểm tra nếu giá trị của 'id_donvi' là null, thì mới kiểm tra tính duy nhất của 'matochuc'
        if ($id_donvi == null) {
            // Kiểm tra tính duy nhất của 'matochuc' khi 'id_donvi' là null
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
        return 'Đơn vị kê khai đã tồn tại trên hệ thống.';
    }
}
