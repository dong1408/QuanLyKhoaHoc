<?php

namespace App\ViewModel\UserInfo;

use App\Models\UserInfo\DMToChuc;
use Ramsey\Uuid\Type\Integer;

class ToChucDetailVm
{
    public int $id;
    public string $matochuc;
    public ?string $tentochuc;
    public ?string $tentochuc_en;
    public ?string $website;
    public ?string $dienthoai;
    public ?string $address;
    public ?TinhThanhVm $addresscity; // $id_address_city -- TinhThanhVm
    public ?QuocGiaVm $addresscountry; // $id_address_country -- QuocGiaVm
    public ?PhanLoaiToChucVm $phanloaitochuc; // $id_phanloaitochuc
    public string $created_at;
    public string $updated_at;
}
