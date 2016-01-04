<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

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
            0 => 'users.id',
            1 => 'users.name',
            2 => 'users.email',
            3 => 'users.enabled'
        );
        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];
        $user_ID = $requestData['user_id_of_current_page'];

        // Base Quary
        $baseQuery = DB::table('panelists')
            ->join('users', 'panelists.user_id', '=', 'users.id')
            ->select(
                'panelists.id',
                'users.name',
                'users.email',
                DB::raw('IF(enabled=1,"Active","Inactive")AS status')
            )
            ->where('panelists.customer_id', '=', $user_ID);
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
}
