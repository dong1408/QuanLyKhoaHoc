<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;

use App\Models\BaiBao\BaiBaoKhoaHoc;
use App\Models\Permission;
use App\Models\SanPham\SanPham;
use App\Models\SanPham\SanPhamTacGia;
use App\Models\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Route;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();


        // $permissions = Permission::all();
        // foreach ($permissions as $permission) {
        //     Gate::define($permission->slug, function (User $user) use ($permission) {
        //         return $user->hasPermission($permission->slug);
        //     });
        // }



        // ====================================================================== //
        // ==========================       USER     ============================ //
        // ====================================================================== //
        // 1. view user 
        Gate::define('user.view', function (User $user) {
            return $user->hasPermission('user.view');
        });

        // 2. view user detail
        Gate::define('user.detail', function (User $user) {
            $userId = Route::current()->parameter('id');
            return $user->hasPermission('user.view') || $user->id == $userId;
        });


        // 3. register user
        Gate::define('user.register', function (User $user) {
            return $user->hasPermission('user.register');
        });

        // 4. update user
        Gate::define('user.update', function (User $user) {
            $userId = Route::current()->parameter('id');
            return $user->hasPermission('user.update') || $user->id == $userId;
        });

        // 5. delete user
        Gate::define('user.delete', function (User $user) {
            $userId = Route::current()->parameter('id');
            return $user->hasPermission('user.delete') || $user->id == $userId;
        });



        // ====================================================================== //
        // =====================         BAI BAO      =========================== //
        // ====================================================================== //

        // 1.view bai bao
        Gate::define('baibao.view', function (User $user) {
            return $user->hasPermission('baibao.view');
        });

        // 2. view cho duyet
        Gate::define('baibao.choduyet', function (User $user) {
            return $user->hasPermission('baibao.choduyet');
        });

        // 3. view bai bao detail
        Gate::define('baibao.detail', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanPhamTacGias = SanPhamTacGia::where('id_sanpham', $id)->get();
            foreach ($sanPhamTacGias as $sanPhamTacGia) {
                if ($sanPhamTacGia->id_tacgia == $user->id) {
                    $flag = true;
                }
            }
            return $user->hasPermission('baibao.detail') || $flag;
        });

        // 4. add bai bao
        Gate::define('baibao.add', function (User $user) {
            return $user->hasPermission('baibao.add');
        });


        // 5. update bai bao
        Gate::define('baibao.update', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanPhamTacGias = SanPhamTacGia::where('id_sanpham', $id)->get();
            foreach ($sanPhamTacGias as $sanPhamTacGia) {
                if ($sanPhamTacGia->id_tacgia == $user->id) {
                    $flag = true;
                }
            }
            return $user->hasPermission('baibao.update') || $flag;
        });


        // 6. update trạng thái rà soát bài báo
        Gate::define('baibao.updateTrangThaiRaSoat', function (User $user) {
            return $user->hasPermission('baibao.updateTrangThaiRaSoat');
        });


        // 7. delete bai bao
        Gate::define('baibao.delete', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanPhamTacGias = SanPhamTacGia::where('id_sanpham', $id)->get();
            foreach ($sanPhamTacGias as $sanPhamTacGia) {
                if ($sanPhamTacGia->id_tacgia == $user->id) {
                    $flag = true;
                }
            }
            return $user->hasPermission('baibao.delete') || $flag;
        });



        // ====================================================================== //
        // ========================      DE TAI      ============================ //
        // ====================================================================== //
        // 1. view de tai
        Gate::define('detai.view', function (User $user) {
            return $user->hasPermission('detai.view');
        });

        // 2. view cho duyet
        Gate::define('detai.choduyet', function (User $user) {
            return $user->hasPermission('detai.choduyet');
        });

        // 3. view de tai detail
        Gate::define('detai.detail', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanPhamTacGias = SanPhamTacGia::where('id_sanpham', $id)->get();
            foreach ($sanPhamTacGias as $sanPhamTacGia) {
                if ($sanPhamTacGia->id_tacgia == $user->id) {
                    $flag = true;
                }
            }
            return $user->hasPermission('detai.detail') || $flag;
        });

        // 4. add de tai
        Gate::define('detai.add', function (User $user) {
            return $user->hasPermission('detai.add');
        });


        // 5. update de tai
        Gate::define('detai.update', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanPhamTacGias = SanPhamTacGia::where('id_sanpham', $id)->get();
            foreach ($sanPhamTacGias as $sanPhamTacGia) {
                if ($sanPhamTacGia->id_tacgia == $user->id) {
                    $flag = true;
                }
            }
            return $user->hasPermission('detai.update') || $flag;
        });

        // 6. update trang thai ra soat de tai
        Gate::define('detai.updateTrangThaiRaSoat', function (User $user) {
            return $user->hasPermission('detai.updateTrangThaiRaSoat');
        });


        // 7. tuyen chon de tai
        Gate::define('detai.tuyenchon', function (User $user) {
            return $user->hasPermission('detai.tuyenchon');
        });

        // 8. xet duyet de tai
        Gate::define('detai.xetduyet', function (User $user) {
            return $user->hasPermission('detai.xetduyet');
        });

        // 9. bao cao de tai
        Gate::define('detai.baocao', function (User $user) {
            return $user->hasPermission('detai.baocao');
        });

        // 10. nghiem thu de tai
        Gate::define('detai.nghiemthu', function (User $user) {
            return $user->hasPermission('detai.nghiemthu');
        });

        // 11. delete de tai
        Gate::define('detai.delete', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanPhamTacGias = SanPhamTacGia::where('id_sanpham', $id)->get();
            foreach ($sanPhamTacGias as $sanPhamTacGia) {
                if ($sanPhamTacGia->id_tacgia == $user->id) {
                    $flag = true;
                }
            }
            return $user->hasPermission('detai.delete') || $flag;
        });


        // ====================================================================== //
        // ====================================================================== //
        // ====================================================================== //
    }
}
