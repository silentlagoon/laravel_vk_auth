<?php
/**
 * Created by PhpStorm.
 * User: Developer
 * Date: 2/4/2015
 * Time: 3:26 PM
 */

class ProfileController extends BaseController
{
    public function showProfile()
    {
        return View::make('profile.profile');
    }
} 