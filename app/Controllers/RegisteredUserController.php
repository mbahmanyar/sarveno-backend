<?php

namespace App\Controllers;

class RegisteredUserController
{


    public function create()
    {
        require view_path('register.php');
    }


    public function show()
    {
        require view_path('login.php');
    }

}