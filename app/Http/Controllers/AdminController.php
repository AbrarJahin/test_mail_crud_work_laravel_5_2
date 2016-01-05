<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AdminController extends Controller
{
//View Start/////////////////////////////////////////////////
	//Showing basic view of users
    public function users()
    {
        return view('admin.users');
    }

    //Showing basic view of articles
    public function articles()
    {
        return view('admin.articles');
    }
//View END/////////////////////////////////////////////////

//AJAX requests - start////////////////////////////////////
    //AJAX route for showing user list
    public function users_list()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'users.name',
            1 => 'users.email',
            2 => 'users.user_type',
            3 => 'users.is_active',
            4 => 'users.created_at',
        );
        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];

        // Base Quary
        $baseQuery = DB::table('users')
            ->select(
                        'users.id',
                        'users.name',
                        'users.email',
                        'users.user_type',
                        'users.is_active',
                        'users.created_at'
                        //DB::raw('IF(enabled=1,"Active","Inactive")AS status'
                    );
        $totalData = $baseQuery->count();
        //Applying Filters
        ////Search Filtering
        $filtered_query = $baseQuery;
        if (!empty($searchParameter))
        {
            $filtered_query = $filtered_query
                                    ->where(function($query) use ($searchParameter)
                                    {
                                        $query
                                            ->where('users.name', 'like', '%'.$searchParameter.'%')
                                            ->orWhere('users.email', 'like', '%' . $searchParameter . '%');
                                    });
        }
        $totalFiltered = $filtered_query->count();
        //Ordering
        $filtered_query = $filtered_query->orderBy($order_by_value, $orderingDirection);
        //Limiting for Pagination
        $data = $filtered_query->skip($limit_start)->take($limit_interval)->get();
        $json_data = array(
                            "draw" => intval($draw_request_code),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
                            "recordsTotal" => intval($totalData),  // total number of records
                            "recordsFiltered" => intval($totalFiltered), // total number of records after searching, if there is no searching then totalFiltered = totalData
                            "data" => $data   // total data array
                        );
        return $json_data;
    }

    public function users_list_activate()
    {
        $requestData = Request::all();

        try
        {
            $user = User::findOrFail($requestData['id']);
            $user->is_active = 'active';
            $user->save();
            return "User activated successfully";
        }
        catch(ModelNotFoundException $e)
        {
            return "Data not found";
        }
    }

    public function users_list_suspend()
    {
        $requestData = Request::all();

        try
        {
            $user = User::findOrFail($requestData['id']);
            $user->is_active = 'suspended';
            $user->save();
            return "User suspended successfully";
        }
        catch(ModelNotFoundException $e)
        {
            return "Data not found";
        }
    }

    public function users_list_delete()
    {
        $requestData = Request::all();

        try
        {
            $user = User::findOrFail($requestData['id']);
            $user->delete();
            return "User deleted successfully";
        }
        catch(ModelNotFoundException $e)
        {
            return "Data not found";
        }
    }
}
