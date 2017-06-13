<?php

namespace App\Http\Controllers;

use App\Models\VRLanguages;
use App\Models\VRPages;
use App\Models\VRPagesCategories;
use App\Models\VRPagesResourcesConnections;
use App\Models\VRPagesTranslations;
use App\Models\VRResources;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class VRPagesController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /menus
     *
     * @return Response
     */
    public function adminIndex()
    {
        $configuration = (new VRPages())->getFillableAndTableName();

        $configuration['message'] = Session()->get('message');

        $configuration['list_data'] = VRPages::get()->where('deleted_at', '=', null)->toArray();

        $configuration['coverImages'] = VRResources::all()->pluck('path', 'id')->toArray();

        $configuration['categories'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if (Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration['translationExist'] = true;
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $configuration = (new VRPages())->getFillableAndTableName();

        array_push($configuration['fields'],"files");

        $configuration['message'] = Session()->get('message');

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();
        $configuration['dropdown']['cover_image_id'] = VRResources::all()->pluck('path', 'id')->toArray();

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $configuration = (new VRPages())->getFillableAndTableName();
        array_push($configuration['fields'], "files");

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();
        $configuration['dropdown']['cover_image_id'] = VRResources::all()->pluck('path', 'id')->toArray();

        $missingValues = '';
        foreach ($configuration['fields'] as $key => $value) {
            if ($value == 'name' and $data['name'] == null) {
                $missingValues = $missingValues . ' ' . $value . ',';
            } else {}
        }

        if ($missingValues != '') {
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.createform', $configuration);
        }

        if (request()->cover_image_id != null) {

            $record = (new VRUploadController())->upload($data['cover_image_id'], null);
            $data['cover_image_id'] = $record->id;
        }

        $pageData = VRPages::create($data)->toArray();

        if (request()->files != null)
        {
            $resourcesId = [];

            foreach ($data['files'] as $resource) {

                    $record = (new VRUploadController())->upload($resource, null);
                    $resourcesId[] = $record->id;
            }

            foreach($resourcesId as $id) {

                VRPagesResourcesConnections::create([
                    'pages_id' => $pageData['id'],
                    'resources_id' => $id
                ]);
            }
        }

        $message = ['message' => trans('Record added successfully')];

        return redirect()->route('app.pages.create')->with($message);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRPages();
        $configuration['record'] = VRPages::find($id)->toArray();

        $configuration['mediaInfo'] = VRResources::find($configuration['record']['cover_image_id'])->toArray();

        $configuration['tableName'] = $dataFromModel->getTableName();

        $pagesCategoriesId = VRPages::find($id)->pages_categories_id;
        $configuration['category'] = VRPagesCategories::find($pagesCategoriesId)->name;

        $resourcesTable_id = VRPages::find($id)->cover_image_id;
        $configuration['image'] = VRResources::find($resourcesTable_id)->path;

        $dataFromModel2 = new VRPagesTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRPagesTranslations::all()->where('pages_id', '=', $id)->toArray();
        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();

        $configuration['connectedMediaDataArrays'] = $this-> mediaFiles($id);

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $configuration = (new VRPages())->getFillableAndTableName();

        $configuration['record'] = VRPages::find($id)->toArray();

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();

        $resourcesTable_id = VRPages::find($id)->cover_image_id;
        if($resourcesTable_id != 0){
            $configuration['coverImage'] = VRResources::find($resourcesTable_id)->path;
        }

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $configuration = (new VRPages())->getFillableAndTableName();

        $missingValues = '';

        foreach ($configuration['fields'] as $key => $value)
        {
            if ($value == 'cover_image_id')
            {}
            elseif (!isset($data[$value]))
            {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }

        if ($missingValues != '') {
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            $configuration['record'] = VRPages::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        if (request()->file('image') != null)
        {
            $data['cover_image_id'] = request()->file('image');
            $resource = request()->file('image');
            $newVRResourcesController = new VRUploadController();
            $resourceId = VRPages::find($id)->cover_image_id;
            $record = $newVRResourcesController->upload($resource, $resourceId);
            $data['cover_image_id'] = $record->id;
        }

        $record = VRPages::find($id);

        $record->update($data);


        DB::table('vr_pages_translations')
            ->wherePages_idAndLanguages_id($id, 'lt')
            ->update([
                         'title' => $record->name,
                         'slug' => str_slug($record->name, '-'),
                     ]);

        $message = ['message' => trans('Record updated successfully')];

        return redirect()->route('app.pages.index')->with($message);
    }

    public function adminDestroy($id)
    {
        if (VRPages::destroy($id) and VRResources::find(VRPages::find($id)->cover_image_id)->delete()){

            if(VRPagesTranslations::where('pages_id', '=', $id)->delete()){
                return json_encode(["success" => true, "id" => $id]);
            }

            else {
                return json_encode(["success" => true, "id" => $id]);
            }
        }
    }
}