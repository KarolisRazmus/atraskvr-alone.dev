<?php

use App\Models\VRPages;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

class PagesSeeder extends Seeder
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
                ["id" => Uuid::uuid4(), "name" => "The lab", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Fruit ninja", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Space pirate trainer", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Tilt brush", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Merry snowballs", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Samsung irklavimas", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "KTU parasparnis", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Hurl", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Final goalie: football simulator", "pages_categories_id" => "vr_categories_id"],
                ["id" => Uuid::uuid4(), "name" => "Project cars", "pages_categories_id" => "vr_categories_id"],

            ];
            DB::beginTransaction();
            try {
                foreach ($list as $single) {
                    $record = VRPages::find($single['id']);
                    if(!$record) {
                        VRPages::create($single);
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
