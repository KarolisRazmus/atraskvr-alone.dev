<?php
use App\Models\VRResources;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Ramsey\Uuid\Uuid;

/**
 * Created by PhpStorm.
 * User: Karolis
 * Date: 6/12/2017
 * Time: 3:11 PM
 */
class ResourcesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $list = [
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497255944_the_lab.jpg", "size" => "67079"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266407_tilt_brush.jpg", "size" => "67058"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266455_hurl.jpg", "size" => "85379"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266467_final_goalie_football_simulator.jpg", "size" => "70614"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266446_ktu_parasparnis.jpg", "size" => "47075"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266434_samsung_irklavimas.jpg", "size" => "71341"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266418_merry_snowballs.jpg", "size" => "42117"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266396_space_pirate_trainer.jpg", "size" => "437108"], // Manage everything
            ["id" => Uuid::uuid4(), "mime_type" => "image/jpeg", "path" => "upload/2017/06/12/1497266388_fruit-ninja.jpg", "size" => "120937"], // Manage everything
        ];

        DB::beginTransaction();
        try {
            foreach ($list as $single) {
                $record = VRResources::find($single['id']);
                if(!$record) {
                    VRResources::create($single);
                }
            }
        } catch(Exception $e) {
            DB::rollback();
            throw new Exception($e);
        }
        DB::commit();
    }
}