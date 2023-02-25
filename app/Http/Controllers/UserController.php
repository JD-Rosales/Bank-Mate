<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserController extends Controller
{
	public function signup(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|max:30',
			'middle_name' => 'required|max:30',
			'last_name' => 'required|max:30',
			'mobile_number' => 'required|max:20',
			'email' =>
			[
				'required',
				Rule::unique('users'),
				'email',
			],
			'pin' => 'required|max:4',
			'type_id' => 'required|exists:user_types,id',
			'password' => 'required|min:8'
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => $validator->errors()->first(),
			], 422);
		}

		$user = User::create([
			'first_name' => $request->first_name,
			'middle_name' => $request->middle_name,
			'last_name' => $request->last_name,
			'mobile_number' => $request->mobile_number,
			'email' => $request->email,
			'pin' => $request->pin,
			'type_id' => $request->type_id,
			'password' => Hash::make($request->password),
		]);


		return response()->json([
			'data' => $user
		]);
	}

	public function login(Request $request)
	{
		$token = $request->bearerToken();

		return response()->json([
			'data' => $request->all(),
			'message' => "test message"
		]);
	}
}
