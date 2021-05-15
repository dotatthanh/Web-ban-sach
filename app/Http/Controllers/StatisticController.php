<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Book;

class StatisticController extends Controller
{
    public function bookStatistic()
    {
    	$books = Book::paginate(10);

    	$data = [
    		'books' => $books,
    	];

    	return view('admin.statistic.book', $data);
    }
}
