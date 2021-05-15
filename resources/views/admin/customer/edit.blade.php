@extends('layout.app')

@section('content')
    <div class="container mt-5">
        @if(session('alert-success'))
            <span class="alert alert-success mt-2 d-block text-center" role="alert">{{ session('alert-success') }}</span>
        @endif

        @if(session('alert-error'))
            <span class="alert alert-danger mt-2 d-block text-center" role="alert">{{ session('alert-error') }}</span>
        @endif
        
        <h1 class="title-admin">Thông tin khách hàng</h1>
    </div>

    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <form class="row" action="{{ route('admin.customer.update', $customer->id) }}" method="post">
                    @csrf
                    <div class="col-md-12">
                        <div class="box">
                            <div class="box-body">
                                <div class="form-group">
                                    <label>Tên</label>
                                    <input type="text" name="name" class="form-control" value="{{ $customer->name }}">
                                    {!! $errors->first('name', '<span class="help-block error">:message</span>') !!}
                                </div>
            
                                <div class="form-group">
                                    <label>Email</label>
                                    <input type="email" name="email" class="form-control" value="{{ $customer->email }}" readonly>
                                    {!! $errors->first('email', '<span class="help-block error">:message</span>') !!}
                                </div>

                                <div class="form-group">
                                    <label>Số điện thoại</label>
                                    <input type="text" name="phone" class="form-control" value="{{ $customer->phone }}">
                                    {!! $errors->first('phone', '<span class="help-block error">:message</span>') !!}
                                </div>

                                <div class="form-group">
                                    <label>Địa chỉ</label>
                                    <input type="text" name="address" class="form-control" value="{{ $customer->address }}">
                                    {!! $errors->first('address', '<span class="help-block error">:message</span>') !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-12">
                        @include('admin.includes.form-action', ['routeIndex' => route('admin.customer.index')])
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection