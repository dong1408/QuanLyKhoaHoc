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

        Gate::define('user.update_role', function (User $user) {
            return $user->hasPermission('user.update_role');
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
        // 4. add de tai
        Gate::define('detai.add', function (User $user) {
            return $user->hasPermission('detai.add');
        });


        // 5. update de tai
        Gate::define('detai.update', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanpham = SanPham::find($id);
            if($sanpham && $sanpham->nguoiKeKhai->id == $user->id){
                 $flag = true;
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
            return $user->hasPermission('detai.delete');
        });


        // ====================================================================== //
        // ==========================    Role Permission    ===================== //
        // ====================================================================== //
        // 1. view role
        Gate::define('role.view', function (User $user) {
            return $user->hasPermission('role.view');
        });

        // 2. add role
        Gate::define('role.add', function (User $user) {
            return $user->hasPermission('role.add');
        });

        // 3, update role
        Gate::define('role.update', function (User $user) {
            return $user->hasPermission('role.update');
        });

        // 4. view permission
        Gate::define('permission.view', function (User $user) {
            return $user->hasPermission('permission.view');
        });

        // 5, add permission
        Gate::define('permission.add', function (User $user) {
            return $user->hasPermission('permission.add');
        });

        // 6, update permission
        Gate::define('permission.update', function (User $user) {
            return $user->hasPermission('permission.update');
        });
    }
}
