<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
class PostsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('posts')->insert([
            [
                'user_id' => 1,
                'title' => '初めての投稿',
                'body' => 'これは初めての投稿です。',
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'title' => 'Laravel勉強中',
                'body' => 'Laravelのシーダー機能を勉強しています。',
                'created_at' => Carbon::now(),
            ],
            [
                'user_id' => 1,
                'title' => 'シーダーテスト',
                'body' => 'ダミーデータが正しく入るか確認しています。',
                'created_at' => Carbon::now(),
            ],
        ]);
    }
}
