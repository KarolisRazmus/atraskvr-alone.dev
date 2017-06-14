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
            } elseif ($value == 'pages_categories_id' and $data['pages_categories_id'] == null) {
                $missingValues = $missingValues . ' ' . substr(str_replace('_', ' ',$value), 0, -6).'y,';
            } else {}
        }

        if ($missingValues != '') {
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.createform', $configuration);
        }

        if(isset($data['cover_image_id'])) {

            if ($data['cover_image_id'] != null) {
                if (is_string($data['cover_image_id'])) {
                } else {
                    $record = (new VRUploadController())->upload($data['cover_image_id'], null);
                    $data['cover_image_id'] = $record->id;
                }
            }
        }

        $pageData = VRPages::create($data)->toArray();

        if(isset($data['files'])) {

            if ($data['files'] != null) {

                $resourcesId = [];

                foreach ($data['files'] as $resource) {
                    $record = (new VRUploadController())->upload($resource, null);
                    $resourcesId[] = $record->id;
                }

                foreach ($resourcesId as $id) {

                    VRPagesResourcesConnections::create([
                        'pages_id' => $pageData['id'],
                        'resources_id' => $id
                    ]);
                }
            }
        }

        $message = ['message' => trans('Record added successfully')];

        return redirect()->route('app.pages.create')->with($message);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRPages();
        $configuration['tableName'] = $dataFromModel->getTableName();

        $configuration['record'] = VRPages::with(['resourcesConnections','category', 'cover_image_id'])->find($id)->toArray();

        $dataFromModel2 = new VRPagesTranslations();
        $configuration['fields_translations'] = $dataFromModel2->getFillable();
        unset($configuration['fields_translations'][1]);
        unset($configuration['fields_translations'][2]);

        $configuration['translations'] = VRPagesTranslations::all()->where('pages_id', '=', $id)->toArray();
        $configuration['languages_names'] = VRLanguages::all()->pluck('name', 'id')->toArray();

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $configuration = (new VRPages())->getFillableAndTableName();
        array_push($configuration['fields'],"files");

        $configuration['record'] = VRPages::with(['resourcesConnections'])->find($id)->toArray();

        $configuration['message'] = Session()->get('message');

        $configuration['dropdown']['pages_categories_id'] = VRPagesCategories::all()->pluck('name', 'id')->toArray();
        $configuration['dropdown']['cover_image_id'] = VRResources::all()->pluck('path', 'id')->toArray();
        $configuration['checkbox']['files']= VRResources::all()->pluck('path', 'id')->toArray();

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
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
            } elseif ($value == 'pages_categories_id' and $data['pages_categories_id'] == null) {
                $missingValues = $missingValues . ' ' . substr(str_replace('_', ' ',$value), 0, -6).'y,';
            } else {}
        }

        if ($missingValues != '') {
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.editform', $configuration);
        }

        dd($data['filesToDelete']);

//        reikia istrinti situos

        if(isset($data['cover_image_id'])) {

            if ($data['cover_image_id'] != null) {
                if (is_string($data['cover_image_id'])) {
                } else {
                    $record = (new VRUploadController())->upload($data['cover_image_id'], null);
                    $data['cover_image_id'] = $record->id;
                }
            }
        }

        $pageData = VRPages::find($id);

        $pageData->update($data);

        if(isset($data['files'])) {

            if ($data['files'] != null) {

                $resourcesId = [];

                foreach ($data['files'] as $resource) {
                    $record = (new VRUploadController())->upload($resource, null);
                    $resourcesId[] = $record->id;
                }

                foreach ($resourcesId as $id) {

                    VRPagesResourcesConnections::create([
                        'pages_id' => $pageData['id'],
                        'resources_id' => $id
                    ]);
                }
            }
        }

        DB::table('vr_pages_translations')
            ->wherePages_idAndLanguages_id($id, 'lt')
            ->update([
                'title' => $pageData->name,
                'slug' => str_slug($pageData->name, '-'),
            ]);

        $message = ['message' => trans('Record updated successfully')];

        return redirect()->route('app.pages.index')->with($message);
    }

    public function adminDestroy($id)
    {
        if (VRPages::destroy($id) and VRPagesTranslations::where('pages_id', '=', $id)->delete() and VRPagesResourcesConnections::where('pages_id', '=', $id)->delete()) {
            return json_encode(["success" => true, "id" => $id]);

        } elseif (VRPages::destroy($id) and VRPagesTranslations::where('pages_id', '=', $id)->delete()) {
            return json_encode(["success" => true, "id" => $id]);

        } elseif (VRPages::destroy($id) and VRPagesResourcesConnections::where('pages_id', '=', $id)->delete()) {
            return json_encode(["success" => true, "id" => $id]);
        } elseif (VRPages::destroy($id)) {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}