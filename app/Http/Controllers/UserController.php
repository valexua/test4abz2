<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;


class UserController extends Controller
{

    protected string $token;
    protected string $apiHost;
    protected object $hCli;

    function __construct(){

        $this->apiHost = env("ABZ_API_HOST","https://frontend-test-assignment-api.abz.agency");
        $this->token = http::get( "{$this->apiHost}/api/v1/token" );
        $this->token = json_decode( $this->token )?->token;

        $this->hCli = http::withHeaders([ "Token" => $this->token ]);
        
        return $this;
    }

    public function index()
    {
        $users = User::orderBy('name')->take(10)->get();

        $usersApi = $this->getApiUsers();

        return view('users.index', compact('users','usersApi'));
    }

    public function loadMoreIndex()
    {
        //log::info('req=',[Request::capture()->all()]);
        
        $offset = request()->input('offset', 10);
        $hasMoreUsers = User::orderBy('name')->skip($offset + 6)->take(1)->exists();

        $users = User::orderBy('name')->skip($offset)->take(6)->get();

        return view('users.more', compact('users', 'hasMoreUsers'))->render();
    }


    function getApiUsers(int $page = 1, int $count = 6){

        $resp = $this->hCli->get( "{$this->apiHost}/api/v1/users", [ "page" => $page, "count" => $count ] )->object();

        //dd($resp->body());
        return $resp?->users ?? [];


    }

    public function getMoreApi()
    {
        //log::info('req=',[Request::capture()->all()]);
        
        $page = request()->input('page');
        $getParams = [ "page" => $page, "count" => 6 ];
        
        $users = $this->hCli->get( "{$this->apiHost}/api/v1/users", $getParams )->object();

        $hasMoreUsers2 = ( $users->success == true ) ? true : false ;
        $users = $users->users ?? [] ;

        return view('users.more', compact('users', 'hasMoreUsers2'))->render();
    }


}


