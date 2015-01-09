<?php

class RegisterController extends BaseController {

    public function showRegister () {
        return View::make('register');
    }
    public function doRegister () {
        $user = new User;
        $user->user_first_name = Input::get('firstname');
        $user->user_last_name = Input::get('lastname');
        $user->user_email = Input::get('email');
        $user->user_login = Input::get('username');
        $user->user_password = Hash::make(Input::get('password'));
        $user->save();
        $theEmail = Input::get('email');
        return View::make('thanks')->with('theEmail', $theEmail) ->with('hashedpw', $user->user_password);
    }

}