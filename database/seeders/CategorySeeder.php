<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Category::factory()
            ->count(16)
            ->create();

        $models = Category::query()->whereBetween('id', [5, 16])->get();

        $pids = [];

        foreach ($models as $key => $model) {
            $pid = mt_rand(1, 4);
            $pids[$pid][] = $pid;
            $model->pid = $pid;
            $model->icon = asset('storage/icons/' . mt_rand(1, 7) . '.png');
            $model->sort = count($pids[$pid]);
            $model->save();
        }
    }
}
