<?php

namespace App\Http\Controllers;

use Cart;
use App\Category;
use App\Author;
use App\News;
use App\Book;
use App\Book_Category;
use App\Contact;
use App\Order;
use App\Customer;
use App\Http\Requests\ContactRequest;
use App\Http\Requests\CustomerRequest;
use DB;
use Illuminate\Http\Request;

class PageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = "Trang chủ";
        $categories = Category::all();

        // Sách Tiếng Việt
        $id_categoryBookTV = Category::where('name', 'Sách Tiếng Việt')->first()->id;
        $bookTVs = Category::find($id_categoryBookTV)->books()->where('amount', '>', 0)->limit(5)->latest()->get();

        // Sách Tiếng Anh
        $id_categoryBookTA = Category::where('name', 'Sách Tiếng Anh')->first()->id;
        $bookTAs = Category::find($id_categoryBookTA)->books()->where('amount', '>', 0)->limit(5)->latest()->get();

        // Sách đang khuyến mãi
        $id_categoryBookSale = Category::where('name', 'Sách đang khuyến mãi')->first()->id;
        $bookSales = Category::find($id_categoryBookSale)->books()->where('amount', '>', 0)->limit(5)->latest()->get();

        // Sách nổi bật
        // $id_categoryBookHighlight = Category::where('name', 'Sách nổi bật')->first()->id;
        // $bookHighlights = Category::find($id_categoryBookHighlight)->books()->where('amount', '>', 0)->limit(5)->latest()->get();
        $bookHighlights = Book::all()->sortByDesc('total_export')->take(3);

        // Sách bán chạy
        // $id_categoryBookSelling = Category::where('name', 'Sách bán chạy')->first()->id;
        // $bookSellings = Category::find($id_categoryBookSelling)->books()->where('amount', '>', 0)->limit(5)->latest()->get();

        // Sách văn học nước ta
        $id_categoryBookLiterature = Category::where('name', 'Sách văn học nước ta')->first()->id;
        $bookLiteratures = Category::find($id_categoryBookLiterature)->books()->where('amount', '>', 0)->limit(5)->latest()->get();

        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");


        return view('page.index', compact('title', 'categories', 'bookTVs', 'bookTAs', 'bookSales', 'bookHighlights', 'bookLiteratures', 'content', 'total', 'id_categoryBookTV', 'id_categoryBookTA', 'id_categoryBookSale', 'id_categoryBookLiterature'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */


    // Chi tiết sách
    public function show($id)
    {
        $book = Book::findOrFail($id);
        $title = "Chi tiết cuốn sách $book->name";
        $categories = Category::all();
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");
        return view ('page.book-detail', compact('title', 'categories', 'book', 'content', 'total'));
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

    // Danh mục sách
    public function category(Request $request, $id)
    {
        $categories = Category::all();
        $category = Category::find($id);
        $books = $category->books()->where('amount', '>', 0)->paginate(8);
        $title = "Danh mục $category->name";
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");

        if($request->key) {
            $books = $category->books()->where('name', 'like', '%'. $request->key .'%')->paginate(8);
        }

        // $books = Book::whereHas('authors', function($query) use ($keyword)
        // {
        //     $query->where('name', 'LIKE', "%$keyword%");
        // })->orWhere('name', 'LIKE', "%$keyword%")
        //   ->with('authors')
        //   ->get();

        $data = [
            'title' => $title,
            'categories' => $categories,
            'category' => $category,
            'books' => $books,
            'content' => $content,
            'total' => $total,
            'request' => $request,

        ];

        return view('page.cate-book', $data);
    }

    // Danh mục sách bán chạy
    public function category_selling(Request $request)
    {
        $categories = Category::all();

        $category = Category::where('name', 'Sách bán chạy')->first();
        $books = $category->books()->paginate(8);
        if($request->key) {
            $books = $category->books()->where('name', 'like', '%'. $request->key .'%')->paginate(8);
        }

        $title = "Danh mục Sách bán chạy";
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");
        return view('page.cate-book', compact('title', 'categories', 'category', 'books', 'content', 'total', 'request'));
    }

    // Danh mục sách đang khuyến mãi
    public function category_sale(Request $request)
    {
        $categories = Category::all();

        $category = Category::where('name', 'Sách đang khuyến mãi')->first();
        $books = $category->books()->paginate(8);
        if($request->key) {
            $books = $category->books()->where('name', 'like', '%'. $request->key .'%')->paginate(8);
        }

        $title = "Danh mục Sách đang khuyến mãi";
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");
        return view('page.cate-book', compact('title', 'categories', 'category', 'books', 'content', 'total', 'request'));
    }
    
    // Danh mục sách mới ra mắt
    public function category_new(Request $request)
    {
        $categories = Category::all();

        // $category = Category::where('name', 'Sách mới ra mắt')->first();
        // $books = $category->books()->paginate(8);

        $books = Book::orderBy('created_at', 'desc')->paginate(8);
        if($request->key) {
            $books = Book::orderBy('created_at', 'desc')->where('name', 'like', '%'. $request->key .'%')->paginate(8);
        }

        $title = "Danh mục Sách mới ra mắt";
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");
        return view('page.cate-book-new', compact('title', 'categories', 'books', 'content', 'total', 'request'));
    }

    // Top nổi bật
    public function tophighlight(){
        $title = 'Top nổi bật';
        $categories = Category::all();
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");

        $books = Book::all()->sortByDesc('total_export')->take(10);
        return view('page.book-hl', compact('title', 'categories', 'content', 'total', 'books'));
    }

    // Diễn đàn
    public function forum(){
        $title = 'Tin tức';
        $categories = Category::all();
        $news = News::latest()->paginate(5);
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");
        $random = News::inRandomOrder()->limit(5)->get();
        return view('page.forum', compact('title', 'categories', 'news', 'content', 'total', 'random'));
    }

    // Chi tiết tin tức
    public function forum_detail($id){
        $title = 'Chi tiêt tin tức';
        $categories = Category::all();
        $news = News::find($id);
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");
        $random = News::inRandomOrder()->limit(5)->get();
        return view('page.forum-detail', compact('title', 'categories', 'news', 'content', 'total', 'random'));
    }

    // Thêm sản phẩm vào giỏ
    public function add_to_cart($id){
        $product_buy = Book::find($id);

        Cart::add([
            'id' => $id,
            'name' => $product_buy->name,
            'qty' => 1,
            'price' => $product_buy->price-($product_buy->price*$product_buy->sale/100),
            'weight' => 0,
            'options' => [
                'img' => $product_buy->img
            ]
        ]);

        $content = Cart::content();

        return redirect()->back();
    }



    // Đặt hàng
    public function order(CustomerRequest $request){
        if(Cart::count() < 1)
        {
            return redirect()->back()->with('notificationOrderFail', 'Đặt hàng thất bại! Giỏ hàng của bạn chưa có sản phẩm!');
        }
        else
        {
            $customer = Customer::create($request->all());

            $content = Cart::content();
            $test = array();
            foreach ($content as $key) {
                $order = new Order;
                $order -> book_id = $key->id;
                $order -> customer_id = $customer->id;
                $order -> price = $key->price;
                $order -> amount = $key->qty;
                $order -> save();

                $book = Book::find($key->id);
                $book->amount = $book->amount - $key->qty;
                $book->save();
            }
            Cart::destroy();
            return redirect()->back()->with('notificationOrder', 'Đặt hàng thành công! Cảm ơn quý khách hàng đã tin tưởng và sử dụng dịch vụ của chúng tôi');;
        }
    }


    // Xóa sản phẩm trỏng giỏ
    public function del_product_cart($id){
        Cart::remove($id);
        return redirect()->back();
    }

    // Xóa tất cả sản phẩm trỏng giỏ
    public function del_cart(){
        Cart::destroy();
        return redirect()->back();
    }
    

    // Sửa sản phẩm trong giỏ
    public function update_product_cart(Request $request, $rowid, $qty){
        // dd($id);
        // if ($request->ajax()) {
        //     $rowid = $request->get('id');
        //     $qty = $request->get('qty');
        //     // if(Book::find($id)->amount > $id = $request->get('idsp')){

        //     // }
        //     Cart::update($rowid, $qty);
        //     echo "oke";
        // }


        // dd($qty);
        // dd($id);
        $id = $request->id;
        $qty = $request->qty;
        $amount = Book::find($id)->amount;
        if($qty > $amount){
            return redirect()->back()->with('notificationUpdate', 'Sửa thất bại! Số lượng sản phẩm cập nhật chỉ còn '.$amount);
        }
        else{
            Cart::update($rowid, $qty);
            return redirect()->back();
        }
    }

    // Liên hệ
    public function contact(){
        $title = 'Chi tiêt tin tức';
        $categories = Category::all();
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");

        return view('page.contact', compact('title', 'categories', 'content', 'total'));
    }

    // Phản hồi
    public function send_us(ContactRequest $request){
        Contact::create($request->all());
        return redirect()->route('page.contact')->with('notificationContact', 'Phản hồi của bạn đã được tiếp nhận!');
    }

    // Tìm kiếm
    public function search(Request $request){
        $title = 'Tìm kiếm';
        $categories = Category::all();
        $content = Cart::content();
        $total = Cart::subtotal(0,",",".",".");
        // $books = Book::where('name', 'like', '%'. $request->keyall .'%')->paginate(10);

        $keyword = $request->keyall;

        $books = Book::whereHas('authors', function($query) use ($keyword)
        {
            $query->where('name', 'LIKE', "%$keyword%");
        })->orWhere('name', 'LIKE', "%$keyword%")
          ->with('authors')
          ->get();
        return view('page.search', compact('title', 'categories', 'content', 'total', 'books'));
    }
}
