
@extends('layouts.vertical', ['title' => 'Tambah User'])

@section('css')
@endsection

@section('content')
    <!-- Start Content-->
    <div class="container-fluid">
        
        <!-- start page title -->
        <div class="row">
            <div class="col-12">
                <div class="page-title-box">
                    <div class="page-title-right">
                        <ol class="breadcrumb m-0">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">{{ env('APP_NAME') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('userlist.index') }}">User</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </div>
                    <h4 class="page-title">User</h4>
                </div>
            </div>
        </div>       
        <!-- end page title --> 
        @if($errors->any())
            <div class="alert alert-warning fade show">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>                        
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <form method="POST" action="{{ route('userlist.store') }}">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name"  name="name"  placeholder="Nama" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" class="form-control @if($errors->has('email')) is-invalid @endif" id="email"  name="email"  placeholder="Email" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label for="group">Role</label>
                                <select class="custom-select @if($errors->has('group')) is-invalid @endif" name="group">
                                    @foreach($groups as $key=>$group)
                                        <option value="{{ $group->id }}" @if(old('group') == $group->id) selected @endif>{{ $group->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password</label>
                                <input type="password" class="form-control @if($errors->has('password')) is-invalid @endif" id="password"  name="password"  placeholder="Password" value="{{ old('password') }}">
                            </div>
                            <div class="form-group">
                                <label for="password_confirmation">Konfirmasi Password</label>
                                <input type="password" class="form-control @if($errors->has('password_confirmation')) is-invalid @endif" id="password_confirmation"  name="password_confirmation"  placeholder="Password" value="{{ old('password_confirmation') }}">
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
                        </form>

                    </div> <!-- end card-body-->
                </div> <!-- end card-->
            </div>
            <!-- end col -->
        
    </div> <!-- container -->
@endsection

@section('script')
@endsection