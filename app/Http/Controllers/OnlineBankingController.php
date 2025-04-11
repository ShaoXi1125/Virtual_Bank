<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Card;
use App\Models\OnlineBankingAccount;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class OnlineBankingController extends Controller
{
    // 显示登录页面
    public function showLoginForm()
    {
        return view('online_banking.login');
    }

    // 登录
    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
        ]);
        // 先获取 account
        $account = OnlineBankingAccount::with('client')->where('username', $request->username)->first();

        // dd($account);
        // 验证账号
        if (!$account || !password_verify($request->password, $account->password)) {
            return redirect()->back()->with('error', 'Invalid credentials');
        }
        // 确认 account 有正确关联的 client
        if (!$account->client) {
            return redirect()->back()->with('error', 'No client associated with this account');
        }
        // dd($account->client);
        // 存入 session
        Session::put('online_banking_user', $account->client->client_id);
        // dd(Session::get('online_banking_user'));
        return redirect()->route('online_banking.dashboard');
    }

    // 显示注册页面
    public function showRegisterForm()
    {
        return view('online_banking.register');
    }

    // 注册
    public function register(Request $request)
    {
        $request->validate([
            'client_id' => 'required|exists:clients,client_id',
            'username' => 'required|string|unique:online_banking_accounts,username',
            'password' => 'required|string|min:6',
        ]);

        $account = OnlineBankingAccount::create([
            'client_id' => $request->client_id,
            'username' => $request->username,
            'password' => bcrypt($request->password),
        ]);

        return redirect()->route('online_banking.login')->with('success', 'Registration successful');
    }

    // 注销
    public function logout()
    {
        Session::forget('online_banking_user');
        return redirect()->route('online_banking.login');
    }

    public function dashboard(Request $request)
    {
        // 获取当前登录用户的 client_id
        $client_id = $request->session()->get('online_banking_user');
    
        // 确保 session 里有 client_id
        if (!$client_id) {
            return redirect()->route('online_banking.login')->with('error', 'Session expired, please log in again.');
        }
    
        // 获取 client 信息
        $client = Client::where('client_id', $client_id)->first();
    
        if (!$client) {
            return redirect()->route('online_banking.login')->with('error', 'Client not found.');
        }
    
        // 获取用户的卡片信息
        $cards = Card::where('client_id', $client_id)->get();
    
        // 传递数据给视图
        return view('online_banking.dashboard', [
            'username' => $client->name, // 假设 client 有 name 字段
            'cards' => $cards
        ]);
    }
}
