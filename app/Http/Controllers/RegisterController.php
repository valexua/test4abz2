<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;


class RegisterController extends UserController
{

    function registerView(){
        $apiData = $this->hCli->get( "{$this->apiHost}/api/v1/positions" );

        //dd($apiData);
        if ($apiData->status() == 200) {
            $viewData = json_decode($apiData->body())?->positions;
            return view('users.register',compact('viewData')); 
        }
        return view('users.register',["viewData" => ["1"=>"error"] ]);
    }


    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                        ->withErrors($validator)
                        ->withInput();
        }

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('users');
    }



    function api_register(){

        $getPosition = $this->hCli->get( "{$this->apiHost}/api/v1/positions" );
        
        $positionIds = collect($getPosition->json()['positions'])->pluck('id')->toArray();
        
        
        # 1. Validation
        $validator = Validator::make(request()->all(), [
            'name' => 'required|string|min:2|max:60',
            'email' => 'required|email|regex:/^[^@]+@[^@]+\.[a-zA-Z]{2,}$/',
            'phone' => [
                'required',
                'string',
                'regex:/^\+380\d{9}$/', 
            ],
            'position_id' => ['required','integer',Rule::in($positionIds)], 
            'photo' => [
                'required',
                'file',
                'mimes:jpeg,jpg', 
                'max:5120', 
            ],
        ]);

        if ($validator->fails()) {
            return redirect('register')->withErrors($validator)->withInput();
        }

        # 2. shrink img
        $shrinkImg = (new ImageController)->shrink_image( request()->file('photo')->get() );


        # 3. send2api /registration

        $regData = [
            'name' => request()->input('name'),
            'email' => request()->input('email'),
            'phone' => request()->input('phone'),
            'position_id' => request()->input('position_id'),
        ];

        
        $reqData2 = [
            (object) [
                "fileName" => request()->file('photo')->getClientOriginalName(),
                "fType"    => 'photo',
                "content"  => $shrinkImg->getContent(),
                "data"     => $regData
            ]
        ];

        //dd($reqData2);

        $regResp = $this->hCli->attach( $reqData2[0]->fType, $reqData2[0]->content, $reqData2[0]->fileName )
                              ->post( "{$this->apiHost}/api/v1/users", $reqData2[0]->data );

        //asMultipart()
        //dd($regResp);

        if ($regResp->status() == 201 ) {

            return redirect()->route('register')->with('success', 'Реєстрація успішна!');

        } else return response()->json(['error' => $regResp->body()], $regResp->status());
    
    }

}
