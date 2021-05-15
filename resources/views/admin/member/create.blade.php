@extends('layout.app')

@section('content')
	<div class="container mt-5">
		@if(session('notificationAdd'))
			<span class="alert alert-success mt-2 d-block text-center" role="alert">{{ session('notificationAdd') }}</span>
		@endif
		@if($errors->has('title') || $errors->has('summary') || $errors->has('img') || $errors->has('content'))
			<span class="alert alert-danger mt-2 d-block text-center" role="alert">Thêm nhân viên thất bại!</span>
		@endif
		@if($errors->has('titleupdate') || $errors->has('summaryupdate') || $errors->has('imgupdate') || $errors->has('contentupdate'))
			<span class="alert alert-danger mt-2 d-block text-center" role="alert">Sửa nhân viên thất bại!</span>
		@endif
		
		<h1 class="title-admin"><span>Thêm</span> Nhân viên</h1>
	</div>

	<div class="container mt-5">
		<form class="row" action="{{ route('admin.member.store') }}" method="post">
			@csrf
			<div class="col-md-12">
				<div class="box">
					<div class="box-body">
						<div class="form-group">
							<label>Tên</label>
							<input type="text" name="name" class="form-control" value="{{ old('name') }}">
							{!! $errors->first('name', '<span class="help-block error">:message</span>') !!}
						</div>

						<div class="form-group">
							<label>Email</label>
							<input type="email" name="email" class="form-control" value="{{ old('email') }}">
							{!! $errors->first('email', '<span class="help-block error">:message</span>') !!}
						</div>
						<div class='form-group'>
							<p class="mr-3">Vai trò</p>
							<select 
								id="addRole"
								class="select2 form-control select2Role" 
								name="roles[]"
								multiple="multiple"
							>
								@foreach ($roles as $item)
									<option value="{{ $item->id }}">{{ $item->name }}</option>
								@endforeach
							</select>
							{!! $errors->first('roles[]', '<span class="help-block error">:message</span>') !!}
						</div>
						<div class="form-group">
							<label>Mật khẩu</label>
							<input type="password" name="password" class="form-control">
							{!! $errors->first('password', '<span class="help-block error">:message</span>') !!}
						</div>
					</div>
				</div>
			</div>

			<div class="col-md-12">
				@include('admin.includes.form-action', ['routeIndex' => route('admin.member.index')])
			</div>
		</form>	
	</div>
@endsection
