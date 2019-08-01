<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Jobs\SendMailAllUser;

class QueueController extends Controller
{
	public function queueMail()
	{
		$allUsers = User::all();

		foreach ($allUsers as $user) {
			dispatch(new SendMailAllUser($user));
		}

		return view('welcome');
	}
}
