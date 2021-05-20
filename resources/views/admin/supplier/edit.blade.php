@extends('layout.app')

@section('content')
    <div class="container mt-5">
        <h1 class="title-admin"><span>Cập nhật</span> nhà cung cấp</h1>
    </div>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-12">
                <form class="form-supplier" action="{{ route('suppliers.update', $dataEdit->id) }}" method="POST" novalidate>
                    @csrf
                    @method('PUT')
                    @include('admin.supplier._form', ['routeType' => 'edit'])
                </form>
            </div>
        </div>
    </div>
@endsection