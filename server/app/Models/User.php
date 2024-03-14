<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Psy\CodeCleaner\FunctionReturnInWriteContextPass;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;
    protected $table = 'users';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'id',
        'name',
        'username',
        'email',
        'password',
        'role',
        'changed',
        'ngaysinh',
        'dienthoai',
        'email2',
        'orchid',
        'id_tochuc',
        'id_donvi',
        'cohuu',
        'keodai',
        'dinhmucnghiavunckh',
        'dangdihoc',
        'id_noihoc',
        'id_ngachvienchuc',
        'id_quoctich',
        'id_hochamhocvi',
        'id_chuyenmon',
        'id_nganhtinhdiem',
        'id_chuyennganhtinhdiem'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    public function getJWTCustomClaims()
    {
        return [];
    }

    // relation n-n to roles (1 ng co nhieu vai tro, 1 vai tro thuoc ve nhieu nguoi)
    public function roles()
    {
        return $this->belongsToMany('App\Models\Role', 'user_role');
    }

    public function hasPermission($permission)
    {
        foreach ($this->roles as $role) {
            if ($role->permissions->where('slug', $permission)->count() > 0) {
                return true;
            }
        }
        return false;
    }


    // inverse to d_m_to_chuc
    public function toChuc()
    {
        return $this->belongsTo('App\Models\UserInfo\DMToChuc', 'id_tochuc');
    }

    // inverse to d_m_to_chuc
    public function noiHoc()
    {
        return $this->belongsTo('App\Models\UserInfo\DMToChuc', 'id_noihoc');
    }

    // inverse to d_m_don_vi
    public function donVi()
    {
        return $this->belongsTo('App\Models\UserInfo\DMDonVi', 'id_donvi');
    }

    // inverse to d_m_ngach_vien_chuc
    public function ngachVienChuc()
    {
        return $this->belongsTo('App\Models\UserInfo\DMNgachVienChuc', 'id_ngachvienchuc');
    }

    // inverse to d_m_quoc_tich
    public function quocGia()
    {
        return $this->belongsTo('App\Models\UserInfo\DMQuocGia', 'id_quoctich');
    }

    // inverse to d_m_hoc_ham_hoc_vi
    public function hocHamHocVi()
    {
        return $this->belongsTo('App\Models\UserInfo\DMHocHamHocVi', 'id_hochamhocvi');
    }

    // inverse to d_m_chuyen_mon
    public function chuyenMon()
    {
        return $this->belongsTo('App\Models\UserInfo\DMChuyenMon', 'id_chuyenmon');
    }

    // inverse to d_m_nganh_tinh_dien
    public function nganhTinhDiem()
    {
        return $this->belongsTo('App\Models\QuyDoi\DMNganhTinhDiem', 'id_nganhtinhdiem');
    }

    // inverse to d_m_chuyen_nganh_tinh_diem
    public function chuyenNganhTinhDiem()
    {
        return $this->belongsTo('App\Models\QuyDoi\DMChuyenNganhTinhDiem', 'id_chuyennganhtinhdiem');
    }

    // relation 1-n to san_pham (trong vai tro la nguoi ke khai)
    public function sanPhamsKeKhai()
    {
        return $this->hasMany('App\Models\SanPham\SanPham', 'id_nguoikekhai');
    }

    // relation 1-n to san_pham (trong vai tro la nguoi ra soat)
    public function sanPhamRaSoat()
    {
        return $this->hasMany('App\Models\SanPham\SanPham', 'id_nguoirasoat');
    }

    // relation 1-n to san_pham_tac_gia (1 tac gia co nhieu san pham (bai bao hoac de tai khoa hoc))
    public function sanPhamsTacGias()
    {
        return $this->hasMany('App\Models\SanPham\SanPhamTacGia', 'id_tac_gia');
    }


    // relation 1-n to tap chi (vai tro la nguoi them tap chi vao he thong)
    public function tapChis()
    {
        return $this->hasMany('App\Models\TapChi\TapChi', 'id_nguoi_them');
    }

    // relation 1-n to tap_chi_khong_cong_nhan (vai tro la nguoi cap nhat tap chi)
    public function tapChiKhongCongNhans()
    {
        return $this->hasMany('App\Models\TapChi\TapChiKhongCongNhan', 'id_nguoicapnhat');
    }

    // relation 1-n to xep_hang_tap_chi 
    public function xepHangTapChis()
    {
        return $this->hasMany('App\Models\TapChi\XepHangTapChi', 'id_user');
    }

    // relation 1-n to tinh_diem_tap_chi
    public function tinhDiemTapChis()
    {
        return $this->hasMany('App\Models\TapChi\TinhDiemTapChi', 'id_nguoicapnhat');
    }


    // relation 1-n to nha_xuat_ban == vai tro la nguoi them nha xuat ban vao he thong
    public function nhaXuatBans()
    {
        return $this->hasMany('App\Models\NhaXuatBan\NhaXuatBan', 'id_nguoithem');
    }
}
