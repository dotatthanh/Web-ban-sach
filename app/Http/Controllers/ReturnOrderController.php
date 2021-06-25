<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\ReturnOrder;
use App\ReturnOrderDetail;
use App\Book;
use App\Order;
use App\OrderDetail;
use DB;
use Auth;

class ReturnOrderController extends Controller
{
    public function index(Request $request)
    {
    	$return_orders = ReturnOrder::paginate(10);

        if($request->code){
            $return_orders = ReturnOrder::where('code', 'like', '%'.$request->code.'%')->paginate(10);
        }

        $data = [
            'title' => "Quản lý đơn hàng trả lại",
            'return_orders' => $return_orders,
            'request' => $request
        ];

    	return view('admin.return-order.index', $data);
    }

    public function create()
    {
    	$orders = Order::where('status', 4)->get();

        $data = [
            'orders' => $orders,
        ]; 

        return view('admin.return-order.create', $data);
    }

    public function store(Request $request)
    {
    	DB::beginTransaction();
        try {
        	$order = Order::findOrFail($request->order_id);
            // tạo đơn hàng trả lại
            $return_order = ReturnOrder::create([
                'code' => 'PT',
                'order_id' => $request->order_id,
                'customer_id' => $order->customer->id,
                'user_id' => Auth::id(),
                'status' => 1,
                'total_money' => 0,
                'reason' => $request->reason,
            ]);
            $return_order->update([
                'code' => 'PT'.str_pad($return_order->id, 6, '0', STR_PAD_LEFT)
            ]);

            $total_money = 0;
            // tạo chi tiết đơn hàng trả lại
            foreach ($request->book_id as $key => $book_id) {
                $book = Book::findOrFail($book_id);

                $order_detail = $order->orderDetails->where('book_id', $book->id)->first();
                if ($request->amount[$key] > $order_detail->amount) {
                    return redirect()->back()->with('alert-error', 'Sản phẩm '.$book->name.' đơn hàng chỉ mua '.$order_detail->amount.' sản phẩm!');
                }

                ReturnOrderDetail::create([
                    'return_order_id' => $return_order->id,
                    'book_id' => $book_id,
                    'amount' => $request->amount[$key],
                    'price' => $book->price,
                    'sale' => $book->sale,
                    'total_money' => $request->amount[$key] * $book->price,
                    'discount' => $request->amount[$key] * $book->price * $book->sale / 100,
                ]);

                $book->update([
                    'amount_return' => $book->amount_return + $request->amount[$key],
                    'amount' => $book->amount + $request->amount[$key],
                ]);

                // Thành tiền 1 sản phẩm
                $total = ($request->amount[$key] * $book->price) - ($request->amount[$key] * $book->price * $book->sale / 100);
                $total_money += $total;
            }

            $return_order->update([
                'total_money' => $total_money
            ]);

            DB::commit();
            return redirect()->route('return-order.index')->with('alert-success', 'Tạo đơn hàng trả lại thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->back()->with('alert-error', 'Tạo đơn hàng trả lại thất bại!');
        }
    }

    public function show($id)
    {
    	$return_order_details = ReturnOrderDetail::where('return_order_id', $id)->paginate(10);
    	
    	$data = [
    		'return_order_details' => $return_order_details,
    	];

    	return view('admin.return-order.detail', $data);
    }

    public function edit($id)
    {
        $return_order = ReturnOrder::findOrFail($id);
        // dd($return_order->order->orderDetails);
        $return_order_details = ReturnOrderDetail::where('return_order_id', $id)->get();

        $data = [
            'return_order_details' => $return_order_details,
            'return_order' => $return_order,
        ];

        return view('admin.return-order.edit', $data);
    }

    public function update(Request $request, $id)
    {
    	DB::beginTransaction();
        try {
            // Đơn hàng trả lại
            $return_order = ReturnOrder::findOrFail($id);
            // Đơn hàng
            $order = Order::findOrFail($return_order->order_id);

            // Hoàn trả số sách trả lại
            foreach ($return_order->returnOrderDetails as $return_order_detail) {
                $book = Book::findOrFail($return_order_detail->book_id);
                $book->update([
                    'amount_return' => $book->amount_return - $return_order_detail->amount,
                ]);
            }

            $return_order->returnOrderDetails()->delete();

            $total_money = 0;
            // tạo chi tiết đơn hàng trả lại
            foreach ($request->book_id as $key => $book_id) {
                $book = Book::findOrFail($book_id);

                $order_detail = $order->orderDetails->where('book_id', $book->id)->first();
                if ($request->amount[$key] > $order_detail->amount) {
                    return redirect()->back()->with('alert-error', 'Sản phẩm '.$book->name.' đơn hàng chỉ mua '.$order_detail->amount.' sản phẩm!');
                }

                ReturnOrderDetail::create([
                    'return_order_id' => $return_order->id,
                    'book_id' => $book_id,
                    'amount' => $request->amount[$key],
                    'price' => $book->price,
                    'sale' => $book->sale,
                    'total_money' => $request->amount[$key] * $book->price,
                    'discount' => $request->amount[$key] * $book->price * $book->sale / 100,
                ]);

                $book->update([
                    'amount_return' => $book->amount_return + $request->amount[$key],
                ]);

                // Thành tiền 1 sản phẩm
                $total = ($request->amount[$key] * $book->price) - ($request->amount[$key] * $book->price * $book->sale / 100);
                $total_money += $total;
            }

            $return_order->update([
                'total_money' => $total_money,
                'reason' => $request->reason,
            ]);

            DB::commit();
            return redirect()->route('return-order.index')->with('alert-success', 'Cập nhật đơn hàng trả lại thành công!');
        } catch (Exception $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
            return redirect()->back()->with('alert-error', 'Cập nhật đơn hàng trả lại thất bại!');
        }
    }

    public function destroy($id)
    {
    	$return_order = ReturnOrder::findOrFail($id);

    	foreach ($return_order->returnOrderDetails as $return_order_detail) {
	    	$return_order_detail->book->update([
	    		'amount_return' => $return_order_detail->book->amount_return - $return_order_detail->amount,
	    	]);
    	}

    	$return_order->returnOrderDetails()->delete();
    	$return_order->delete();

    	return redirect()->back()->with('alert-success', 'Xóa đơn hàng thành công!');
    }

    public function getBookInOrder($id)
    {
    	$order = Order::findOrFail($id)->orderDetails()->with('book')->get();

    	return $order;
    }

    public function getOrderDetail(Request $request)
    {
        $order_detail = OrderDetail::where('order_id', $request->order_id)->where('book_id', $request->book_id)->first();

        return $order_detail;
    }
}
