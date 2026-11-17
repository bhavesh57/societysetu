<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Society;
use App\Models\SocietyMember;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request): JsonResponse
    {
        $request->validate([
            'society_code' => ['nullable', 'string', 'max:60'],
            'login' => ['required_without_all:mobile,email', 'nullable', 'string', 'max:150'],
            'mobile' => ['required_without_all:login,email', 'nullable', 'string', 'max:150'],
            'email' => ['required_without_all:login,mobile', 'nullable', 'string', 'max:150'],
            'password' => ['nullable', 'string'],
            'pin' => ['nullable', 'string'],
        ]);

        $societyCode = strtoupper(trim((string) $request->input('society_code', '')));
        $identifier = trim((string) ($request->input('login') ?? $request->input('mobile') ?? $request->input('email') ?? ''));
        $password = trim((string) ($request->password ?? $request->pin ?? ''));

        if (empty($password)) {
            return response()->json([
                'success' => false,
                'message' => 'Password or PIN is required.',
            ], 422);
        }

        $society = null;
        if ($societyCode !== '') {
            $society = Society::where('society_code', $societyCode)->first();
            if (!$society || $society->status !== 'active') {
                return response()->json([
                    'success' => false,
                    'message' => 'Active society not found for provided society code.',
                ], 404);
            }
        }

        $user = User::findByLoginIdentifier($identifier, $society?->id, $society?->society_code);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Account not found for the provided credentials.',
            ], 404);
        }

        $isPasswordValid = ($user->password && Hash::check($password, $user->password)) ||
                           ($user->pin && Hash::check($password, $user->pin));

        if (!$isPasswordValid) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid password or PIN credentials.',
            ], 401);
        }

        if (!$society) {
            $membership = SocietyMember::with('society')
                ->where('user_id', $user->id)
                ->where('status', 'active')
                ->whereHas('society', fn ($q) => $q->where('status', 'active'))
                ->first();
            $society = $membership?->society;
        }

        if (!$society) {
            return response()->json([
                'success' => false,
                'message' => 'User does not belong to an active society.',
            ], 403);
        }

        if (empty($user->user_name) && !empty($user->mobile)) {
            $user->user_name = User::generateUserName($user->mobile, $society->society_code);
            $user->save();
        }

        $memberships = SocietyMember::where('society_id', $society->id)
            ->where('user_id', $user->id)
            ->where('status', 'active')
            ->pluck('role_type')
            ->toArray();

        if (empty($memberships)) {
            return response()->json([
                'success' => false,
                'message' => 'User does not belong to this society.',
            ], 403);
        }

        $token = $user->createToken('society-setu-mobile', $memberships)->plainTextToken;

        return response()->json([
            'success' => true,
            'message' => 'Authentication successful.',
            'data' => [
                'token' => $token,
                'token_type' => 'Bearer',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'user_name' => $user->user_name,
                    'email' => $user->email,
                    'mobile' => $user->mobile,
                ],
                'society' => [
                    'id' => $society->id,
                    'name' => $society->name,
                    'society_code' => $society->society_code,
                    'city' => $society->city,
                ],
                'available_roles' => $memberships,
                'primary_role' => in_array('committee_member', $memberships) ? 'committee_member' : $memberships[0],
            ],
        ]);
    }

    public function me(Request $request): JsonResponse
    {
        $user = $request->user();

        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'societies' => $user->societies()->get(),
            ],
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'success' => true,
            'message' => 'Logged out and token revoked.',
        ]);
    }
}
