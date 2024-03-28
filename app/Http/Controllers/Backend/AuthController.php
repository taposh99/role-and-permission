<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;


class AuthController extends BaseController
{

    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', $validator->errors());
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;

        return $this->sendResponse($success, 'User register successfully.');
    }

    public function login(Request $request)
    {
        //     if(  Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
        //         $user = Auth::user(); 
        //         $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
        //         $success['name'] =  $user->name;

        //         $data = [
        //             $user->load(['roles' => function ($query) {
        //                 $query->select('user_id', 'name');
        //             }]),

        //         ];

        //         return $this->sendResponse($success, 'User login successfully.',$data);
        //     } 
        //     else{ 
        //         return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        //     } 
        // }
        $user = User::where('email', $request->email)->first();
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            $data = [
                'user' => $user->load('roles:user_id,name'),
                $success['token'] =  $user->createToken('MyApp')->plainTextToken,
                $success['name'] =  $user->name,
            ];
        }

        return $this->sendResponse('User login successfully.', $data);
    }
}
