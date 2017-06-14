<?php

namespace App\Http\Controllers;

use App\Models\VRPagesResourcesConnections;
use App\Models\VRResources;

class VRResourcesController extends Controller
{
    public function adminIndex()
    {
        $configuration = (new VRResources())->getFillableAndTableName();

        $configuration['message'] = Session()->get('message');

        $configuration['list_data'] = VRResources::get()->where('deleted_at', '=', null)->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
//        $configuration = (new VRResources())->getFillableAndTableName();
//
//        $configuration['message'] = Session()->get('message');
//
//        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->file('files');

        $configuration = (new VRResources())->getFillableAndTableName();

        if (request()->file('files') == null)
        {
            $configuration['error'] = ['message' => trans('Please add some file')];
            return view('admin.createform', $configuration);
        }

        foreach($data as $resource) {
            (new VRUploadController())->upload($resource, null);
        }

        $message = ['message' => trans('Record added successfully')];

        return redirect()->route('app.resources.index')->with($message);
    }

    public function adminShow($id)
    {
        $dataFromModel = new VRResources();
        $configuration['record'] = VRResources::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {

    }

    public function adminUpdate($id)
    {

    }

    public function adminDestroy($id)
    {
        if (VRResources::destroy($id) and VRPagesResourcesConnections::where('resources_id', '=', $id)->delete())
        {
            return json_encode(["success" => true, "id" => $id]);

        }elseif(VRResources::destroy($id))
        {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}
