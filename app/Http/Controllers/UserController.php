<?php

namespace App\Http\Controllers;

use Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use DB;
use App\Article;
use App\Balance;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Facades\Redirect;
use Auth;

class UserController extends Controller
{
    public function my_articles()       //Showing My Articles
    {
        return view('user.my_articles');
    }

    public function all_articles()      //Showing All Articles
    {
        return view('user.all_articles');
    }

    public function all_articles_public_list()  //Datatable for public activated articles
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
                    )
            ->where('article.status', '=', 'active');
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

    public function my_articles_public_list()   //Datatable for my all articles
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
                    )
            ->where('article.user_id', '=', Auth::user()->id);
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

    public function add_articles()              //Ading an article
    {
        $requestData = Request::all();
        $flight = new Article;
        $flight->user_id    = Auth::user()->id;
        $flight->title      = $requestData['title'];
        $flight->content    = $requestData['title'];
        $flight->status     = "inactive";
        $flight->save();
        return Redirect::back()->withErrors(['Article Successfully Added']);
    }

    public function delete_article()            //Deleting an article
    {
        $requestData = Request::all();;
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

    public function get_articles()              //Get an article for editing
    {
        $requestData = Request::all();
        try
        {
            return Article::findOrFail($requestData['id']);
        }
        catch(ModelNotFoundException $e)
        {
            return "Article not found";
        }
    }

    public function edit_articles()             //Updating edited Article
    {
        $requestData = Request::all();
        try
        {
            $article = Article::findOrFail($requestData['id']);
            $article->title     = $requestData['title'];
            $article->content   = $requestData['content'];
            $article->save();
            return Redirect::back()->withErrors(['Article Successfully Updated']);
        }
        catch(ModelNotFoundException $e)
        {
            return Redirect::back()->withErrors(['Article not found']);
        }
    }

    public function show_balance()              //Balance Showing
    {
        return view('user.balance')
            ->with('balance',Balance::where('user_id', Auth::user()->id)->sum('money_amount'))
            ->with('transections',Balance::where('user_id', Auth::user()->id)->orderBy('created_at')->get());
    }

    public function add_balance()               //Adding Balance
    {
        $requestData = Request::all();
        $balance = new Balance;
        $balance->user_id           = Auth::user()->id;
        $balance->money_amount      = $requestData['balance'];
        $balance->transection_by    = 'user';
        $balance->save();
        return Redirect::back()->withErrors(['Balance Successfully Added']);
    }
}
