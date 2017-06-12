<?php

namespace App\Http\Controllers;

use App\Models\VROrders;
use App\Models\VRPagesCategories;
use Illuminate\Support\Facades\Route;

class VROrdersController extends Controller
{
    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function displays all Orders existing in data base
     */
    public function adminIndex()
    {
        $configuration = (new VROrders())->getFillableAndTableName();
        array_unshift($configuration['fields'], 'id');

        $configuration['message'] = Session()->get('message');

        $configuration['list_data'] = VROrders::get()->where('deleted_at', '=', null)->toArray();

        if ($configuration['list_data'] == []) {
            $configuration['error'] = ['message' => trans("List is empty. Please create some " . $configuration['tableName'] . ", then check list again")];
            return view('admin.list', $configuration);
        }

        if(Route::has('app.' . $configuration['tableName'] . '_translations.create')) {
            $configuration[ 'translationExist' ] = true;
        }

        return view('admin.list', $configuration);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function shows Order creating form
     */
    public function adminCreate()
    {
        $configuration = (new VROrders())->getFillableAndTableName();

        $configuration['message'] = Session()->get('message');

        $configuration['enum_dropDown'] = [
            "label" => trans('status'),
            "values" => VROrders::$STATUS
        ];

        return view('admin.createform', $configuration);
    }

    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Function takes Order data from Order create form and stores to data base
     */
    public function adminStore()
    {
        $data = request()->all();

        $configuration = (new VROrders())->getFillableAndTableName();

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

        VROrders::create($data);

        $message = ['message' => trans('Record added successfully')];

        return redirect()->route('app.orders.create')->with($message);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Displays details of only one Order found in data base by ID
     */
    public function adminShow($id)
    {
        $dataFromModel = new VROrders();
        $configuration['record'] = VROrders::find($id)->toArray();
        $configuration['tableName'] = $dataFromModel->getTableName();

        return view('admin.single', $configuration);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Shows editing form of one Order found in data base by ID
     */
    public function adminEdit($id)
    {
        $configuration = (new VROrders())->getFillableAndTableName();

        $configuration['record'] = VROrders::find($id)->toArray();

        $configuration['enum_dropDown'] = [
            "label" => trans('status'),
            "values" => VROrders::$STATUS
        ];

        return view('admin.editform', $configuration);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     *
     * Updates data of one Order in data base by ID, checks if all fields are filled
     */
    public function adminUpdate($id)
    {
        $data = request()->all();

        $configuration = (new VROrders())->getFillableAndTableName();

        $missingValues = '';
        foreach ($configuration['fields'] as $key => $value) {
            if (!isset($data[$value])) {
                $missingValues = $missingValues . ' ' . $value . ',';
            }
        }
        if ($missingValues != '') {
            $missingValues = substr($missingValues, 1, -1);
            $configuration['error'] = ['message' => trans('Please enter ' . $missingValues)];
            $configuration['record'] = VROrders::find($id)->toArray();
            return view('admin.editform', $configuration);
        }

        VROrders::find($id)->update($data);

        $message = ['message' => trans('Record updated successfully')];

        return redirect()->route('app.orders.index')->with($message);
    }

    public function adminDestroy($id)
    {
        if (VROrders::destroy($id))
        {
            return json_encode(["success" => true, "id" => $id]);
        }
    }
}

