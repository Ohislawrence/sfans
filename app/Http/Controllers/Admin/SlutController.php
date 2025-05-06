<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class SlutController extends Controller
{
    public function view()
    {
        $sluts = User::whereHas('roles', fn($q) => $q->where('name', 'slut'))->paginate(10);
        return view('admin.chat.sluts', compact('sluts'));
    }
}
