<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
   
class RegisterController extends BaseController
{

    public function register(Request $request) {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:1',
            'email' => 'required|email|unique:users,email|min:3',
            'password' => 'required|min:8',
            'c_password' => 'required|same:password|min:8',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    public function login(Request $request) {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 

            /** @var \App\Models\User $user **/
            $user = Auth::user(); 
            $user->tokens()->delete();
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }

    public function logout(Request $request) {
      
            $user = User::find($request->id); 
            $user->tokens()->where('id', $request->token)->delete();
            $success['id'] =  $request->id;
   
            return $this->sendResponse($success, 'User logout successfully. Token cleared.');
  
    }


}