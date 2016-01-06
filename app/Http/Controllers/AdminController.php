<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\User;
use App\Article;
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

//AJAX Datatables requests - start////////////////////////////////////
    //AJAX route for showing user list
    public function users_list()
    {
        //This type of complex query is provided so that u can check my query skill
        //This complex query is essential for Datatables because everything in the datatables is done by this single query
        //Show, ordering, searching, limiting, pagination, count total no of elements
        //Details for all datatables complex query is almost same, so, in another place comments are not provided
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

    public function users_list_activate()       //Activate User
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

    public function users_list_suspend()    //Suspend User
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

    public function users_list_delete()     //Delete User
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

    //AJAX route for showing articles list
    public function articles_list()
    {
        $requestData = Request::all();

        $columns = array(
            // datatable column index  => database column name
            0 => 'users.name',
            1 => 'article.title',
            2 => 'article.content',
            3 => 'article.status',
            4 => 'article.created_at',
        );
        $draw_request_code = $requestData['draw'];
        $searchParameter = $requestData['search']['value'];
        $order_by_value = $columns[$requestData['order'][0]['column']];
        $orderingDirection = $requestData['order'][0]['dir'];
        $limit_start = $requestData['start'];
        $limit_interval = $requestData['length'];

        // Base Quary
        $baseQuery = DB::table('article')
            ->join('users', 'users.id', '=', 'article.user_id')
            ->select(
                        'article.id',
                        'users.name',
                        'article.title',
                        'article.content',
                        'article.status',
                        'article.created_at'
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
                                            ->orWhere('article.title', 'like', '%' . $searchParameter . '%')
                                            ->orWhere('article.content', 'like', '%' . $searchParameter . '%');
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

    public function articles_list_activate()        //Activate Article
    {
        $requestData = Request::all();

        try
        {
            $article = Article::findOrFail($requestData['id']);
            $article->status = 'active';
            $article->save();
            return "Article activated successfully";
        }
        catch(ModelNotFoundException $e)
        {
            return "Article not found";
        }
    }

    public function articles_list_suspend()        //Suspend Article
    {
        $requestData = Request::all();

        try
        {
            $article = Article::findOrFail($requestData['id']);
            $article->status = 'suspended';
            $article->save();
            return "Article suspended successfully";
        }
        catch(ModelNotFoundException $e)
        {
            return "Article not found";
        }
    }

    public function articles_list_delete()        //Delete Article
    {
        $requestData = Request::all();

        try
        {
            $article = Article::findOrFail($requestData['id']);
            $article->delete();
            return "Article deleted successfully";
        }
        catch(ModelNotFoundException $e)
        {
            return "Article not found";
        }
    }
}
