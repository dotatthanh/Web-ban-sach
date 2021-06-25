<?php

namespace App\Http\Controllers;

use App\Category;
use App\Book_Category;
use Illuminate\Http\Request;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CategoryUpdateRequest;

class CategoryController extends Controller
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
        $categories = Category::paginate(10);
        if($request->key){
            $key = $request->key;
            $categories = Category::where('name', 'like', '%'. $request->key .'%')->paginate(10);
        }
        $data = [
            'title' => "Quản lý danh mục sách",
            'categories' => $categories,
            'request' => $request,

        ];
        return view('admin.category', $data);
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
    public function store(CategoryRequest $request)
    {
        $request['code'] = 'DM';
        $category = Category::create($request->all());

        $category->update([
            'code' => 'DM'.str_pad($category->id, 4, '0', STR_PAD_LEFT)
        ]);

        return redirect()->route('categorys.index')->with('alert-success', 'Thêm thành công!');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(CategoryUpdateRequest $request, $id)
    {
        Category::findOrFail($id)->update([
            'name' => $request->nameupdate,
        ]);
        return redirect()->route('categorys.index')->with('alert-success', 'Sửa thành công!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if ($id <= 3) {
            return redirect()->back()->with('alert-error', 'Xóa thất bại! Danh mục này đang hiển thị trên website!');
        }
        elseif (Category::findOrFail($id)->books->count() != 0)
        {
            return redirect()->back()->with('alert-error', 'Xóa thất bại! Cần xóa hết các sách thuộc danh mục này trước');
        }
        else
        {
            Category::findOrFail($id)->delete();
            return redirect()->back()->with('alert-success', 'Xóa thành công!');
        }
    }
}
