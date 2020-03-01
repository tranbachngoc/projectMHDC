<?php

use Illuminate\Database\Seeder;

class ChatThreadsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
      DB::table('chatthreads')->insert([
            'type' => 'group',
            'namegroup' => 'Khách hàng đã mua',
            'ownerId' => 0,
            'requesterId' => 0,
            'typegroup' => 'default'
      ]);

      DB::table('chatthreads')->insert([
            'type' => 'group',
            'namegroup' => 'Nhân viên',
            'ownerId' => 0,
            'requesterId' => 0,
            'typegroup' => 'default'
      ]);

      DB::table('chatthreads')->insert([
            'type' => 'group',
            'namegroup' => 'Chi nhánh',
            'ownerId' => 0,
            'requesterId' => 0,
            'typegroup' => 'default'
      ]);

      DB::table('chatthreads')->insert([
            'type' => 'group',
            'namegroup' => 'Afflliate của mình',
            'ownerId' => 0,
            'requesterId' => 0,
            'typegroup' => 'default'
      ]);

      DB::table('chatthreads')->insert([
            'type' => 'group',
            'namegroup' => 'Người chọn bán hàng cho mình',
            'ownerId' => 0,
            'requesterId' => 0,
            'typegroup' => 'default'
      ]);


    }
}
