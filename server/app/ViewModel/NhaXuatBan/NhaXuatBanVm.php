<?php

namespace App\ViewModel\NhaXuatBan;

use App\Models\NhaXuatBan\NhaXuatBan;
use App\ViewModel\User\UserVm;
use App\ViewModel\UserInfo\QuocGiaVm;
use App\ViewModel\UserInfo\TinhThanhVm;
use App\ViewModel\UserInfo\ToChucVm;
use PhpOffice\PhpSpreadsheet\Calculation\Logical\Boolean;
use Ramsey\Uuid\Type\Integer;
use Symfony\Component\Console\Input\StringInput;

class NhaXuatBanVm
{
    public int $id;
    public string $name;
}
