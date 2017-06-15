<?php

use App\Models\VRPagesCategories;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PagesCategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        {
            $list = [
                ["id" => "without_categories_id", "name" => "Does not have a category"],
                ["id" => "vr_categories_id", "name" => "Virtual room category"],
                ["id" => "menu_categories_id", "name" => "Menu category"],

            ];
            DB::beginTransaction();
            try {
                foreach ($list as $single) {
                    $record = VRPagesCategories::find($single['id']);
                    if(!$record) {
                        VRPagesCategories::create($single);
                    }
                }
            } catch(Exception $e) {
                DB::rollback();
                throw new Exception($e);
            }
            DB::commit();

        }
    }
}
