<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\OnlineBankingAccount;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class OnlineBankingAccountController extends Controller
{
    //
     // ✅ 开户功能
     public function register(Request $request, $client_id)
     {
         $request->validate([
             'username' => 'required|string|unique:online_banking_accounts,username',
             'password' => 'required|string|min:6',
         ]);
 
         $client = Client::find($client_id);
 
         if (!$client) {
             return response()->json(['message' => 'Client not found'], 404);
         }
 
         // 判断是否已有账户
         if ($client->onlineBankingAccount) {
             return response()->json(['message' => 'Account already exists'], 400);
         }
 
         // 创建 OnlineBankingAccount
         $account = OnlineBankingAccount::create([
             'client_id' => $client_id,
             'username' => $request->username,
             'password' => Hash::make($request->password),
             'status' => 'active',
             'last_login' => now(),
         ]);
 
         return response()->json(['message' => 'Online banking account created successfully', 'account' => $account], 201);
     }
 
     // ✅ 登录功能
     public function login(Request $request)
     {
         $request->validate([
             'username' => 'required|string',
             'password' => 'required|string',
         ]);
 
         $account = OnlineBankingAccount::where('username', $request->username)->first();
 
         if (!$account || !Hash::check($request->password, $account->password)) {
             return response()->json(['message' => 'Invalid credentials'], 401);
         }
 
         $account->update(['last_login' => now()]);
 
         return response()->json(['message' => 'Login successful', 'account' => $account], 200);
     }
 
     // ✅ 修改密码功能
     public function updatePassword(Request $request, $account_id)
     {
         $request->validate([
             'current_password' => 'required|string',
             'new_password' => 'required|string|min:6',
         ]);
 
         $account = OnlineBankingAccount::find($account_id);
 
         if (!$account || !Hash::check($request->current_password, $account->password)) {
             return response()->json(['message' => 'Invalid current password'], 403);
         }
 
         $account->update(['password' => Hash::make($request->new_password)]);
 
         return response()->json(['message' => 'Password updated successfully'], 200);
     }
 
     // ✅ 获取账户信息
     public function getAccountInfo($account_id)
     {
         $account = OnlineBankingAccount::with('client')->find($account_id);
 
         if (!$account) {
             return response()->json(['message' => 'Account not found'], 404);
         }
 
         return response()->json($account, 200);
     }
}
