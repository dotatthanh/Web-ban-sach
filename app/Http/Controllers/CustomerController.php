<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Http\Requests\CustomerRequest;
use App\Http\Requests\LoginRequest;
use App\Category;
use App\Customer;

class CustomerController extends Controller
{
    public function register() {
        $categories = Category::paginate(10);
        if($request->key){
            $key = $request->key;
            $categories = Category::where('name', 'like', '%'. $request->key .'%')->paginate(10);
        }

        $data = [
            'title' => "Đăng ký tài khoản",
            'categories' => $categories,
            'content' => [],
            'total' => '',
        ];
        return view('page.user.register', $data);
    }

    public function postRegister(RegisterRequest $request) {
        $params = $request->all();
        DB::beginTransaction();

        $created = $this->user->create([
            'name' => $params['name'],
            'phone' => $params['phone'],
            'address' => $params['address'],
            'email' => $params['email'],
            'remember_token' => Str::random(60),
            'password' => Hash::make($params['password_confirm']),
        ]);

        if ($created) {
            DB::commit();
            return redirect()->route('page')->with('alert-success', 'Đăng ký tài khoản thành công');
        } else {
            DB::rollback();
            return redirect()->back()->with('alert-error', 'Đăng ký tài khoản thất bại');
        }
    }

    public function login(Request $request) {
        $categories = Category::paginate(10);
        if($request->key){
            $key = $request->key;
            $categories = Category::where('name', 'like', '%'. $request->key .'%')->paginate(10);
        }

        $data = [
            'title' => "Đăng nhập tài khoản",
            'categories' => $categories,
            'content' => [],
            'total' => '',
        ];
        return view('page.user.login', $data);
    }

    public function postLogin(LoginRequest $request) {
        $params = $request->all();

        $remember = isset($params['remember']) ? true : false;
        if(Auth::guard('web')->attempt([
            'email'=>$params['email'], 
            'password'=>$params['password']
        ], $remember)){
            return redirect()->route('page')->with('alert-success', 'Đăng nhập thành công');
        } else{
            return redirect()->back()->with('alert-error', 'Sai tài khoản hoặc mật khẩu');
        }
    }

    public function index(Request $request) {
        $query = Customer::query();

        if ($request->has('key')) {
            $query = $query->where('name', 'like', '%'.$request->key.'%');
        }

        $customers = $query->paginate(10);

        $viewData = [
            'customers' => $customers,
            'key' => $request->key,
        ];

        return view("admin.customer.index", $viewData);
    }

    public function edit($id) {
        $customer = Customer::findOrFail($id);
        return view('admin.customer.edit', compact('customer'));
    }

    public function update(CustomerRequest $request, $id) {
        try {
            $customer = Customer::findOrFail($id);
            $data = $request->all();

            $data = array_merge($request->all(), [
                'code' => 0
            ]);
            $customer->update($data);
            return redirect()->route('admin.customer.index')->with('alert-success','Cập nhật thông tin khách hàng thành công!');
        } catch (Exception $e) {
            return redirect()->back()->with('alert-danger', 'Cập nhật thông tin khách hàng thất bại!');
        }
    }

    public function destroy($id) {
        $user = Customer::findOrFail($id);
        $user->delete();
        return redirect()->route('admin.customer.index')->with('alert-success', 'Xóa khách hàng thành công!');
    }
}
