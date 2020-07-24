
@extends('layouts.vertical', ['title' => 'Tambah Rubrik'])

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
                            <li class="breadcrumb-item"><a href="{{ route('rubrik.index') }}">Rubrik</a></li>
                            <li class="breadcrumb-item active">Tambah</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Rubrik</h4>
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
                        <form method="POST" action="{{ route('rubrik.store') }}">
                            @csrf
                            @method('POST')
                            <div class="form-group">
                                <label for="name">Nama</label>
                                <input type="text" class="form-control @if($errors->has('name')) is-invalid @endif" id="name"  name="name"  placeholder="Nama Rubrik" value="{{ old('name') }}">
                            </div>
                            <div class="form-group">
                                <label for="description">Deskripsi</label>
                                <textarea class="form-control" id="description" name="description" rows="3">{{ old('description') }}</textarea>
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