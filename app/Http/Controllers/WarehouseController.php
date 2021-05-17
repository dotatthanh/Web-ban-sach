<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ImportOrder;
use App\ImportOrderDetail;
use App\Book;
use App\Supplier;
use Auth;

class WarehouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $warehouses = ImportOrder::paginate(10);

        if ($request->code) {
            $warehouses = ImportOrder::where('code', $request->code)->paginate(10);
        }

        $data = [
            'warehouses' => $warehouses,
        ]; 

        return view('admin.warehouse.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $books = Book::all();
        $suppliers = Supplier::all();

        $data = [
            'books' => $books,
            'suppliers' => $suppliers,
        ]; 

        return view('admin.warehouse.import_book', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // dd($request->all());

        // tạo đơn nhập hàng
        $import_order = ImportOrder::create([
            'code' => 'PN'.strval(ImportOrder::count()+1),
            'user_id' => Auth::id(),
            'supplier_id' => $request->supplier_id,
            'total_money' => 0,
        ]);

        $total_money = 0;
        // tạo chi tiết đơn nhập hàng
        foreach ($request->book_id as $key => $book_id) {
            ImportOrderDetail::create([
                'import_order_id' => $import_order->id,
                'book_id' => $book_id,
                'amount' => $request->amount[$key],
                'price' => $request->price[$key],
            ]);
            $total = $request->amount[$key] * $request->price[$key];
            $total_money += $total;
        }

        $import_order->update([
            'total_money' => $total_money
        ]);

        return redirect()->route('warehouses.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $import_order_details = ImportOrderDetail::where('import_order_id', $id)->paginate(10);

        $data = [
            'import_order_details' => $import_order_details
        ];

        return view('admin.warehouse.import_order_detail', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
