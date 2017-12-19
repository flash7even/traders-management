<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShowStatisticController extends Controller
{
    public function showSellHistory(Request $request)
    {
       	return view('sell_history');
    }
    public function showBuyHistory(Request $request)
    {
       	return view('buy_history');
    }
    public function showDueHistory(Request $request)
    {
       	return view('due_history');
    }

}
