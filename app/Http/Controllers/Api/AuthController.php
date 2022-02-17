<?php
   
namespace App\Http\Controllers\API;
   
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
// use App\Http\Controllers\Api\BaseController as BaseController;
use App\Models\User;

   
class AuthController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required|email',
            // 'phone' => 'required',
            // 'imgProfile' => 'required',
            'password' => 'required',
            'password_confirmation' => 'required|same:password',
        ]);
   
        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
   
        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $user = User::create($input);
        $success['token'] =  $user->createToken('MyApp')->plainTextToken;
        $success['name'] =  $user->name;
        $success['email'] =  $user->email;
        // $success['imgProfile'] =  $user->imgProfile;
        // $success['phone'] =  $user->phone;
   
        return $this->sendResponse($success, 'User register successfully.');
    }
   
    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){ 
            $user = Auth::user(); 
            $success['token'] =  $user->createToken('MyApp')->plainTextToken; 
            $success['name'] =  $user->name;
            $success['email'] =  $user->email;
            // $success['imgProfile'] =  $user->imgProfile;
            // $success['phone'] =  $user->phone;
   
            return $this->sendResponse($success, 'User login successfully.');
        } 
        else{ 
            return $this->sendError('Unauthorised.', ['error'=>'Unauthorised']);
        } 
    }
   /**
     * logout api
     *
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $response = ['data' => 'Logout successful.'];
        return response()->json($response, 201);
    }
   /**
     * Forgot Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request){
        $input = $request->only('email');
        $validator = Validator::make($input, [
            'email' => "required|email"
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $response = Password::sendResetLink($input);
    
        $message = $response == Password::RESET_LINK_SENT ? 'Mail send successfully' : 'GLOBAL_SOMETHING_WANTS_TO_WRONG';
        
        return response()->json($message);
    }
   /**
     * Reset Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function passwordReset(Request $request){
        $input = $request->only('email','token', 'password', 'password_confirmation');
        $validator = Validator::make($input, [
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ]);
        if ($validator->fails()) {
            return response()->json($validator->errors());
        }
        $response = Password::reset($input, function ($user, $password) {
            $user->password = Hash::make($password);
            $user->save();
        });
        $message = $response == Password::PASSWORD_RESET ? 'Password reset successfully' : 'GLOBAL_SOMETHING_WANTS_TO_WRONG';
        return response()->json($message);
    }
    /**
     * update Password api
     *
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $rules = [
            'current_password' => ['required', 'min:6'],
            'password' => ['required', 'min:6', 'confirmed'], //need to pass password_confirmation also in request
        ];

        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        if (!Hash::check($request->get('current_password'), $request->user()->password)) {
            return response()->json(['errors' => 'The provided password does not match your current password.'], 404);
        }

        $request->user()->forceFill([
            'password' => Hash::make($request->get('password')),
        ])->save();

        return response(['data' => 'Password set successfully.'], 201);
    }
}
