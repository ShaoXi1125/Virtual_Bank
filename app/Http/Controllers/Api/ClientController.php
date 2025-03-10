<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Client;

class ClientController extends Controller
{
    // 1. 获取所有客户信息
    public function index() {
        return response()->json(Client::all());
    }

    // 2. 获取单个客户信息
    public function show($id) {
        $client = Client::find($id);
        return $client ? response()->json($client) : response()->json(['error' => 'Client not found'], 404);
    }

    // 3. 创建新客户（注册）
    public function store(Request $request) {
        $request->validate([
            'client_name'  => 'required|string|max:255',
            'client_email' => 'required|email|unique:clients',
            'client_phone' => 'nullable|string|max:15',
        ]);

        $client = Client::create($request->all());

        return response()->json($client, 201);
    }
}
