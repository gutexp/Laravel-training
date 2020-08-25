<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class Controller extends BaseController //we can see that the controller is only serving us to bring a bunch of methods from different collections to our other controller classes trough enheritance
{                                       //it gives us power and the non-need to always export the methods to the other controllers classes
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
