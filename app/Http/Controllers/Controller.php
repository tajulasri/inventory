<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
	const ERROR_KEY = '_error';
	const SUCCESS_KEY = '_success';
	const SUCCESS_MESSAGE = 'Data has been succesfully save';
	const ERROR_MESSAGE = 'Oops! ..look something bad happen.Please try later.';
	const VALIDATION_MESSAGE = 'All field are required!.';
	
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
}
