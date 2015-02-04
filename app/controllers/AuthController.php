<?php

use Illuminate\Database\Eloquent\ModelNotFoundException;

App::error(function(ModelNotFoundException $e)
{
    $message = 'Username or password is incorrect';
    return View::make('auth.login')->with('message', $message);
});

/**
 * Class AuthController
 */

class AuthController extends BaseController
{
    protected $layout = 'layouts.master';

    public static function vksettings()
    {
        return array(
            'urlAuth' => 'http://oauth.vk.com/authorize',
            'urlToken' => 'https://oauth.vk.com/access_token',
            'client_id' => '4764660',
            'client_secret' => 'HJhd5Qzn2TUIwpGghyP7',
            'redirect_uri' => 'http://laravel.local:8080/vkauth'
        );
    }

    public function vkauth()
    {
        if(Input::has('code'))
        {
            $vkData = self::vksettings();
            $params = array(
                'client_id' => $vkData['client_id'],
                'client_secret' => $vkData['client_secret'],
                'code' => Input::get('code'),
                'redirect_uri' => $vkData['redirect_uri'],
            );
            $token = json_decode(file_get_contents($vkData['urlToken'] . '?' . urldecode(http_build_query($params))), true);

            if(isset($token['access_token']))
            {
                $params = array(
                    'uids' => $token['user_id'],
                    'fields' => 'uid,first_name,last_name,sex,bdate',
                    'access_token' => $token['access_token']
                );
                $userInfo = json_decode(file_get_contents('https://api.vk.com/method/users.get' . '?' . urldecode(http_build_query($params))), true);

                if (isset($userInfo['response'][0]['uid']))
                {
                    $userInfo = $userInfo['response'][0];
                    $validator = Validator::make(array('email' => $token['email']), array(
                            'email' => 'unique:users'
                        )
                    );
                    if($validator->fails())
                    {
                        $user = User::where('email', $token['email'])->firstOrFail();
                        if($user->vkid == $userInfo['uid']);
                        {
                            Auth::loginUsingId($user->id);
                            return Redirect::to('/profile');
                        }
                    }
                    else
                    {
                        $user = new User;
                        $user->email = $token['email'];
                        $user->vkid = $userInfo['uid'];
                        $user->save();
                        Auth::loginUsingId($user->id);
                        return Redirect::to('/profile');
                    }
                }
            }
        }
    }

    public function login()
    {
        if (Request::isMethod('post'))
        {
            $data = Input::all();

            $validator = Validator::make(
                $data,
                array(
                    'email' => 'required|min:3',
                    'password' => 'required|min:3'
                )
            );

            if($validator->fails())
            {
                $message = 'Username or password is incorrect';
                return View::make('auth.login')->with('message', $message);
            }
            else
            {
                $user = User::where('email', $data['email'])->firstOrFail();
                if(Auth::attempt(array('email' => $data['email'], 'password' => $data['password'])))
                {
                    return Redirect::to('/profile');
                }
                else
                {
                    $message = 'Password is incorrect';
                    return View::make('auth.login')->with('message', $message);
                }
            }
        }
        if(Request::isMethod('get'))
        {
            if(Auth::check())
            {
                return Redirect::intended('/profile');
            }
            else
            {
                $vkData = self::vksettings();
                $params = array(
                    'client_id'     => $vkData['client_id'],
                    'redirect_uri'  => $vkData['redirect_uri'],
                    'response_type' => 'code',
                    'scope' => 'email'
                );
                $url = $vkData['urlAuth'] . '?' . urldecode(http_build_query($params));
                return View::make('auth.login')->with('vk', $url);
            }
        }

    }

    public function register()
    {
        if (Request::isMethod('post'))
        {
            $data = Input::all();

            $validator = Validator::make(
                $data,
                array(
                    'email' => 'required|min:3|unique:users',
                    'password' => 'required|min:3|confirmed',
                    'password_confirmation' => 'required|min:3'
                )
            );

            if($validator->fails())
            {
                $messages = $validator->messages();
                $response = $messages->all();
                return View::make('auth.register')->with('response', $response);
            }
            else
            {
                $user = new User;
                $user->email = $data['email'];
                $user->password = Hash::make($data['password']);
                $user->save();

                Auth::loginUsingId($user->id);
                return Redirect::to('/profile');
            }
        }
        if(Request::isMethod('get'))
        {
            if(Auth::check())
            {
                return Redirect::intended('/profile');
            }
            else
            {
                return View::make('auth.register');
            }
        }
    }

    public function logout()
    {
        Auth::logout();
        return Redirect::to('/login');
    }
}