<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;
use App\User;
use App\Order;

class StatisticController extends Controller
{
    public function bookStatistic(Request $request)
    {
    	$books = Book::query();

    	if ($request->name) {
    		$books = $books->where('name', 'like', '%'.$request->name.'%');
    	}

    	if ($request->amount) {
    		if ($request->amount == 'Còn hàng') {
	    		$books = $books->where('amount', '>', 0);
    		}
    		if ($request->amount == 'Hết hàng') {
	    		$books = $books->where('amount', 0);
    		}
    	}

    	$books = $books->paginate(10);

    	$data = [
    		'books' => $books,
            'request' => $request,
    	];

    	return view('admin.statistic.book', $data);
    }

    public function staffRevenue(Request $request)
    {
        $users = User::query();

        if ($request->name) {
            $users = $users->where('name', 'like', '%'.$request->name.'%');
        }

        $users = $users->paginate(10);

        $revenue = Order::where('status', 4)->sum('total_money');

        $data = [
            'users' => $users,
            'request' => $request,
            'revenue' => $revenue,
        ];

        return view('admin.statistic.staff_revenue', $data);
    }
}
