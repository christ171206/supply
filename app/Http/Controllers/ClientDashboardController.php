<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ClientDashboardController extends Controller
{

    public function index()
    {
        return view('client.dashboard');
    }

    public function commandes()
    {
        return view('client.commandes');
    }

    public function panier()
    {
        return view('client.panier');
    }
}
