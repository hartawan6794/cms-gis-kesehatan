<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
	{

	    $data = [
                'controller'    	=> 'dashboard',
                'title'     		=> 'Dashboard'				
			];
		
		return view('dashboard', $data);
			
	}
}
