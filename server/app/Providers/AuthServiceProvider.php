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
            return $user->hasPermission('user.view');
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
            return $user->hasPermission('user.delete');
        });



        // ====================================================================== //
        // =====================         BAI BAO      =========================== //
        // ====================================================================== //
        // 4. add bai bao
        Gate::define('baibao.add', function (User $user) {
            return $user->hasPermission('baibao.add');
        });

        Gate::define('baibao.view', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            if($id != null){
                $sanpham = SanPham::find($id);

                if($sanpham && $sanpham->nguoiKeKhai->id == $user->id){
                    $flag = true;
                }
            }
            return $user->hasPermission('baibao.view') || $flag;
        });

        // 5. update bai bao
        Gate::define('baibao.update', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanpham = SanPham::find($id);

            if($sanpham && $sanpham->nguoiKeKhai->id == $user->id){
                $flag = true;
            }
            return $user->hasPermission('baibao.update') || $flag;
        });


        // 6. update trạng thái rà soát bài báo
        Gate::define('baibao.status', function (User $user) {
            return $user->hasPermission('baibao.status');
        });


        // 7. delete bai bao
        Gate::define('baibao.delete', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            $sanpham = SanPham::find($id);

            if($sanpham && $sanpham->nguoiKeKhai->id == $user->id){
                $flag = true;
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

        Gate::define('detai.view', function (User $user) {
            $id = Route::current()->parameter('id');
            $flag = false;
            if($id != null){
                $sanpham = SanPham::find($id);

                if($sanpham && $sanpham->nguoiKeKhai->id == $user->id){
                    $flag = true;
                }
            }
            return $user->hasPermission('detai.view') || $flag;
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

        // trạng thái rà soát + tuyển chọn + báo cáo + nghiệm thu
        Gate::define('detai.status', function (User $user) {
            return $user->hasPermission('detai.status');
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

    }
}
