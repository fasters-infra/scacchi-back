<?php

namespace App\Http\Controllers;
use App\Models\Profile;

class ProfileController extends BaseController
{
    public function __construct()
    {
        $this->classe = Profile::class;
    }
}
