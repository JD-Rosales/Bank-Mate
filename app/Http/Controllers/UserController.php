<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class UserController extends Controller
{
	public function signup(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'first_name' => 'required|max:30',
			'middle_name' => 'required|max:30',
			'last_name' => 'required|max:30',
			'mobile_number' => 'required|size:11|unique:users,mobile_number',
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
			'pin' => Hash::make($request->pin),
			'type_id' => $request->type_id,
			'password' => Hash::make($request->password),
		]);


		return response()->json([
			'data' => $user
		]);
	}

	public function login(Request $request)
	{
		$validator = Validator::make($request->all(), [
			'email' => 'required',
			'password' => 'required'
		]);

		if ($validator->fails()) {
			return response()->json([
				'message' => $validator->errors()->first(),
			], 422);
		}

		$credentials = $request->only('email', 'password');

		if (Auth::attempt($credentials)) {
			$token = $request->user()->createToken($request->email);

			return response()->json([
				'token' => $token->plainTextToken,
			]);
		} else {
			return response([
				'message' => 'Invalid email or password.'
			], 403);
		}
	}
}
