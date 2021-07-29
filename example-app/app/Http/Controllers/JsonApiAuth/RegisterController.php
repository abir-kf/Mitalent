<?php

namespace App\Http\Controllers\JsonApiAuth;

use App\Http\Controllers\JsonApiAuth\Traits\HasToShowApiTokens;
use App\Http\Requests\JsonApiAuth\RegisterRequest;
use App\Http\Requests\JsonApiAuth\ClientRequest;
use App\Notifications\JsonApiAuth\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Validation\Rules\Password;

class RegisterController extends Controller
{
    use HasToShowApiTokens;

    /**
     * @param RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function __invoke(RegisterRequest $request)
    {
        try {

            $fields = $request->validate([
                "username"  => "required|string|max:6|unique:users,username",
                "email"     => "required|email|unique:users,email",
                "categorie"     => "required",
                'password' => ['required', 'string', 'confirmed', 
                 Password::min(8)->letters()->numbers()->mixedCase()//->symbols()
                ]
            ]);
    
            $random = mt_rand(10,99);
            
    
            $user = User::create([
                "username"  => $fields['username'] .$random,
                "email"     => $fields['email'],
                "categorie"     => $fields['categorie'],
                "image" => null,
                "password"  => Hash::make($fields['password'])
            ]);
    

            /** @var User $user */
            /*$user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);*/

            if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                $user->notify(new VerifyEmailNotification);
            }

            

            // You can customize on config file if the user would show token on register to directly register and login at once.

            //return aussi image null
            return $this->showCredentials($user, 201, config('json-api-auth.show_token_after_register'));

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }



    public function __client(ClientRequest $request)
    {
        try {

            $fields = $request->validate([
                "sirene"  => "required|string|unique:clients,sirene",
                "email"     => "required|email|unique:clients,email",
                'password' => ['required', 'string', 'confirmed', 
                 Password::min(8)->letters()->numbers()->mixedCase()//->symbols()
                ]
            ]);
    
            
            
    
            $user = User::create([
                "sirene"  => $fields['sirene'],
                "email"     => $fields['email'],           
                "password"  => Hash::make($fields['password'])
            ]);


    

            /** @var User $user */
            /*$user = User::create([
                'name' => $request->get('name'),
                'email' => $request->get('email'),
                'password' => Hash::make($request->get('password')),
            ]);*/

            if($user instanceof MustVerifyEmail && ! $user->hasVerifiedEmail()) {
                $user->notify(new VerifyEmailNotification);
            }

            

            // You can customize on config file if the user would show token on register to directly register and login at once.

            //return aussi image null
            return $this->showCredentials_client($user, 201, config('json-api-auth.show_token_after_register'));

        } catch (\Exception $exception) {

            return response()->json([
                'message' => $exception->getMessage()
            ], 400);

        }
    }

    
}
