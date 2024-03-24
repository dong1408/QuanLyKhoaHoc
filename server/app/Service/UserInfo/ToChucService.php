<?php

namespace App\Service\UserInfo;

use App\Http\Requests\UserInfo\ToChuc\CreateToChucRequest;
use App\Http\Requests\UserInfo\ToChuc\UpdateToChucRequest;
use App\Models\UserInfo\DMToChuc;
use App\Utilities\ResponseSuccess;
use Illuminate\Http\Request;

interface ToChucService
{
    public function getAllToChuc(Request $request): ResponseSuccess;
    public function getToChucPaging(Request $request): ResponseSuccess;
    public function getDetailToChuc(int $id): ResponseSuccess;
    public function themToChucNgoai($array): DMToChuc;
    public function createToChuc(CreateToChucRequest $request): ResponseSuccess;
    public function updateToChuc(UpdateToChucRequest $request, int $id): ResponseSuccess;
    public function deleteToChuc(int $id): ResponseSuccess;
}
