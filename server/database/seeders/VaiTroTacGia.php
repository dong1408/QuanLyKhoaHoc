<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VaiTroTacGia extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $vaiTroTacGias = [
            [
                'tenvaitro' => 'Tác Giả Đầu Tiên',
                'mota' => 'Vai trò tác giả đầu tiên',
                'tenvaitro_en' => 'First Author',
                'role' => 'baibao',
                'mavaitro' => 'tacgiadautien'
            ],
            [
                'tenvaitro' => 'Tác Giả Liên Hệ',
                'mota' => 'Vai trò tác giả liên hệ',
                'tenvaitro_en' => 'Corresponding Author',
                'role' => 'baibao',
                'mavaitro' => 'tacgialienhe'
            ],
            [
                'tenvaitro' => 'Tác Giả',
                'mota' => 'Vai trò tác giả cộng tác',
                'tenvaitro_en' => 'CO-Author',
                'role' => 'baibao',
                'mavaitro' => 'tacgia'
            ],
            [
                'tenvaitro' => 'Chủ Nhiệm',
                'mota' => 'Giữ vai trò là chủ nhiệm chính của đề tài',
                'tenvaitro_en' => 'Principal Investigator',
                'role' => 'detai',
                'mavaitro' => 'chunhiem'
            ],
            [
                'tenvaitro' => 'Thành viên chính',
                'mota' => 'Thành viên chính thực hiện đề tài',
                'tenvaitro_en' => 'CO-Investigator',
                'role' => 'detai',
                'mavaitro' => 'thanhvienchinh'
            ],
            [
                'tenvaitro' => 'Thư Ký Khoa Học',
                'mota' => 'Thư ký đề tài',
                'tenvaitro_en' => 'Research Secretary',
                'role' => 'detai',
                'mavaitro' => 'thukykhoahoc'
            ],
            [
                'tenvaitro' => 'Thành viên',
                'mota' => 'Thành viên của đề tài',
                'tenvaitro_en' => 'Research Member',
                'role' => 'detai',
                'mavaitro' => 'thanhvien'
            ],
        ];

        foreach($vaiTroTacGias as $item){
            DB::table('d_m_vai_tro_tac_gias')->insert($item);
        }
    }
}
