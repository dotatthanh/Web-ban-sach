<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

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
	    		$books = $books->whereHas('importOrderDetails', function ($query) {
				    return $query->where('amount', '>', 0);
				});
    		}
    		if ($request->amount == 'Hết hàng') {
	    		$books = $books->whereHas('importOrderDetails', function ($query) {
				    return $query->where('amount', 0);
				});
    		}
    	}

    	$books = $books->paginate(10);

    	$data = [
    		'books' => $books,
    	];

    	return view('admin.statistic.book', $data);
    }
}
