<?php

namespace App\Http\Controllers;

use App\Book;
use App\Supplier;
use App\Type;
use App\Category;
use App\Author;
use App\Author_Book;
use App\Book_Type;
use App\Book_Category;
use Illuminate\Http\Request;
use App\Http\Requests\BookRequest;
use App\Http\Requests\BookUpdateRequest;

class BookController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $books = Book::paginate(10);

        if($request->key) {
            $key = $request->key;
            $books = Book::where('name', 'like', '%'. $request->key .'%')->paginate(10);
        }

        $data = [
            'title' => "Quản lý sách",
            'books' => $books,
            'suppliers' => Supplier::all(),
            'authors' => Author::all(),
            'types' => Type::all(),
            'categories' => Category::all(),
            'request' => $request
        ];
        return view('admin.book', $data);
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
    public function store(BookRequest $request)
    {
        $data = $request->all();
        // xử lý img
        if ($request->hasFile('img')) {
            $file1Extension = $request->file('img')
                ->getClientOriginalExtension();
            $fileName1 = uniqid() . '.' . $file1Extension;
            $request->file('img')
                ->storeAs('public', $fileName1);
            $data['img'] = $fileName1;
        }

        // Book
        $book = Book::create($data);

        // Book_type
        $type_id = $request->type;
        if($type_id != null)
        {
            for ($i=0; $i < count($type_id); $i++) { 
                $book_type = new Book_Type;
                $book_type->book_id = $book->id;
                $book_type->type_id = $type_id[$i];
                $book_type->save();
            }
        }

        // Book_category
        $category_id = $request->category;
        if($category_id != null)
        {
            for ($i=0; $i < count($category_id); $i++) { 
                $book_category = new Book_Category;
                $book_category->book_id = $book->id;
                $book_category->category_id = $category_id[$i];
                $book_category->save();
            }
        }

        // Author_Book
        $author_id = $request->author_id;
        if($author_id != null)
        {
            for ($i=0; $i < count($author_id); $i++) { 
                $author_book = new Author_Book;
                $author_book->author_id = $author_id[$i];
                $author_book->book_id = $book->id;
                $author_book->save();
            }
        }

        return redirect()->route('books.index')->with('notificationAdd', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function show(Book $book)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function edit(Book $book)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function update(BookUpdateRequest $request, $id)
    {
        $data = [
            'supplier_id' => $request->supplierupdate,
            'name' => $request->nameupdate,
            'img' => $request->imgupdate,
            'price' => $request->priceupdate,
            'sale' => $request->saleupdate,
            'content' => $request->contentupdate,
        ];

        // xử lý img
        if ($request->hasFile('imgupdate')) {
            $file1Extension = $request->file('imgupdate')
                ->getClientOriginalExtension();
            $fileName1 = uniqid() . '.' . $file1Extension;
            $request->file('imgupdate')
                ->storeAs('public', $fileName1);
            $data['img'] = $fileName1;
        }

        Book::findOrFail($id)->update($data);


        // Book_type
        Book_Type::where('book_id', $id)->delete();
        $type_id = $request->typeupdate;
        if($type_id != null)
        {
            for ($i=0; $i < count($type_id); $i++) { 
                $book_type = new Book_Type;
                $book_type->book_id = $id;
                $book_type->type_id = $type_id[$i];
                $book_type->save();
            }
        }

        // Book_category
        Book_Category::where('book_id', $id)->delete();
        $category_id = $request->categoryupdate;
        if($category_id != null)
        {
            for ($i=0; $i < count($category_id); $i++) { 
                $book_category = new Book_Category;
                $book_category->book_id = $id;
                $book_category->category_id = $category_id[$i];
                $book_category->save();
            }
        }

        // Author_Book
        Author_Book::where('book_id', $id)->delete();
        $author_id = $request->authorupdate;
        if($author_id != null)
        {
            for ($i=0; $i < count($author_id); $i++) { 
                $author_book = new Author_Book;
                $author_book->book_id = $id;
                $author_book->author_id = $author_id[$i];
                $author_book->save();
            }
        }
        
        return redirect()->route('books.index')->with('notificationUpdate', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Book  $book
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Book::findOrFail($id)->bookCategorys()->delete();
        Book::findOrFail($id)->bookTypes()->delete();
        Book::findOrFail($id)->authorBooks()->delete();
        Book::findOrFail($id)->delete();
        return redirect()->back()->with('notificationDelete', 'Xóa thành công!');
    }
}
