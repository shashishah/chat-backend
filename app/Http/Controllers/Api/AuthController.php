<?php 
namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Agent;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request) {
        $agent = Agent::where('email', $request->email)->first();
        if (!$agent || !Hash::check($request->password, $agent->password)) {
            return response()->json(['message'=>'Invalid credentials'], 401);
        }
        $token = $agent->createToken('agent-token')->plainTextToken;
        return response()->json(['token' => $token, 'agent' => $agent]);
    }

    public function logout(Request $request) {
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message'=>'Logged out']);
    }
}
