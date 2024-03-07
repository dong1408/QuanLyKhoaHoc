<?php

namespace App\ViewModel\QuyDoi;

use App\Models\QuyDoi\DMChuyenNganhTinhDiem;

class ChuyenNganhTinhDiemDetailVm
{
    public int $id;
    //public ?NganhTinhDiemVm $nganhtinhdiem; // $id_nganhtinhdiem
    public string $machuyennganh;
    public ?string $tenchuyennganh;
    public ?string $tenchuyennganh_en;
    public string $created_at;
    public string $updated_at;

}
