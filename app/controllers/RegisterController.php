<?php

class RegisterController extends BaseController {

    public function showRegister () {
        return View::make('register');
    }
    public function doRegister () {
        $user = new User;
        $user->firstname = Input::get('firstname');
        $user->lastname = Input::get('lastname');
        $user->email = Input::get('email');
        $user->username = Input::get('username');
        $user->password = Hash::make(Input::get('password'));
        $user->save();
        $theEmail = Input::get('email');
        return View::make('thanks')->with('theEmail', $theEmail);
    }

}