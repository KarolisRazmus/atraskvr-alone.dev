<?php

namespace App\Http\Controllers;

use App\Models\VRUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;

class VRUsersController extends Controller
{
    /**
     * Display a listing of the resource.
     * GET /users
     *
     * @return Response
     */
    public function adminIndex()
    {
        $configuration = (new VRUsers())->getFillableAndTableName();
        unset($configuration['fields'][3]);

        $configuration['message'] = Session()->get('message');

        $configuration['list_data'] = VRUsers::get()->where('deleted_at', '=', null)->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . str_replace('_', ' ', $configuration['tableName']) . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    public function adminCreate()
    {
        $configuration = (new VRUsers())->getFillableAndTableName();

        $configuration['message'] = Session()->get('message');

        return view('admin.createform', $configuration);
    }

    public function adminStore()
    {
        $data = request()->all();

        $configuration = (new VRUsers())->getFillableAndTableName();

        $missingValues= '';
        foreach($configuration['fields'] as $key=> $value) {
            if (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }
        if ($missingValues != ''){
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            return view('admin.createform', $configuration);
        }

        VRUsers::create($data);

        $message = ['message' => trans('Record added successfully')];

        return redirect()->route('app.users.create')->with($message);
    }

    public function adminShow($id)
    {
        $configuration = (new VRUsers())->getFillableAndTableName();

        $configuration['record'] = VRUsers::find($id)->toArray();

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.single', $configuration);
    }

    public function adminEdit($id)
    {
        $configuration = (new VRUsers())->getFillableAndTableName();

        $configuration['record'] = VRUsers::find($id)->toArray();

        return view('admin.editform', $configuration);
    }

    public function adminUpdate($id)
    {
        $data = request()->all();

        $configuration = (new VRUsers())->getFillableAndTableName();

        $missingValues= '';
        foreach($configuration['fields'] as $key=> $value) {
            if (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }
        if ($missingValues != ''){
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            $configuration['record'] = VRUsers::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        VRUsers::find($id)->update($data);

        $message = ['message' => trans('Record updated successfully')];

        return redirect()->route('app.users.index')->with($message);
    }

    public function adminDestroy($id)
    {
        if (VRUsers::destroy($id))
        {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}
