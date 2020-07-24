
@extends('layouts.vertical', ['title' => 'Ubah Artikel'])

@section('css')
<link href="{{asset('assets/libs/summernote/summernote.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/dropify/dropify.min.css')}}" rel="stylesheet" type="text/css" />
<link href="{{asset('assets/libs/selectize/selectize.min.css')}}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item"><a href="{{ route('post.index') }}">Artikel</a></li>
                            <li class="breadcrumb-item active">Ubah</li>
                        </ol>
                    </div>
                    <h4 class="page-title">Artikel</h4>
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
        <form class="fom" enctype="multipart/form-data" method="POST" action="{{ route('post.update', $row->id) }}">
            <div class="row">
                <div class="col-lg-9">
                    <div class="card">
                        <div class="card-body">
                            @csrf
                            @method('PATCH')
                            <div class="form-group">
                                <label for="title">Judul</label>
                                <input type="text" class="form-control" id="title"  name="title"  placeholder="Judul Artikel" value="{{ $row->title }}">
                            </div>
                            <div class="form-group">
                                <label for="keyword">Keyword</label>
                                <input type="text" class="form-control" id="keyword"  name="keyword"  placeholder="Keyword Artikel" value="{{ $row->keyword }}">
                            </div>
                            <div class="form-group">
                                <label for="excerpt">Cuplikan</label>
                                <textarea class="form-control" id="excerpt" name="excerpt" rows="2" placeholder="Cuplikan Artikel">{{ $row->excerpt }}</textarea>
                            </div>
                            <div class="form-group">
                                <label for="content">Konten</label>
                                <textarea class="form-control summernote" id="content" name="content" rows="3" placeholder="Konten Artikel">{{ $row->content }}</textarea>
                            </div>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
                <div class="col-lg-3">
                    <div class="card">
                        <div class="card-body">
                            <div class="form-group">
                                <label for="category">Kategori</label>
                                <select class="custom-select @if($errors->has('category')) is-invalid @endif" name="category">
                                    <option value="">Pilih Kategori</option>
                                    @foreach($categories as $key=>$category)
                                        <option value="{{ $category->id }}" @if($row->categoryposts->category_id == $category->id) selected @endif>{{ $category->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="custom-select" name="status">
                                    <option value="0" @if($row->status == 0) selected @endif>Draft</option>
                                    <option value="1" @if($row->status == 1) selected @endif>Publish</option>
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="comment">Ijinkan komentar</label>
                                <select class="custom-select" name="comment">
                                    <option value="0" @if($row->comment == 0) selected @endif>Tidak</option>
                                    <option value="1" @if($row->comment == 1) selected @endif>Iya</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-info waves-effect waves-light">Simpan</button>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                    <div class="card">
                        <div class="card-body">
                            <h4 class="header-title">Thumbnail</h4>
                            <?php if(!empty($row->thumbnail)){
                                $thumb = secure_asset($row->thumbnail);
                            }else{
                                $thumb = '';
                            };?>
    
                            <input name="thumbnail" type="file" data-plugins="dropify" data-height="300" data-default-file="{{ $thumb }}"/>
                        </div> <!-- end card-body-->
                    </div> <!-- end card-->
                </div>
            </div>
        </form>
            <!-- end col -->
        
    </div> <!-- container -->
@endsection

@section('script')
<!-- Plugins js-->
<script src="{{asset('assets/libs/summernote/summernote.min.js')}}"></script>
<script src="{{asset('assets/libs/selectize/selectize.min.js')}}"></script>
<script src="{{asset('assets/libs/dropify/dropify.min.js')}}"></script>

<!-- Page js-->

<script>
    jQuery(document).ready(function(){
        $('.summernote').summernote({
            height: 500,                 // set editor height
            minHeight: null,             // set minimum height of editor
            maxHeight: null,             // set maximum height of editor
            focus: false,                 // set focus to editable area after initializing summernote
        });
        
        if ($('[data-plugins="dropify"]').length > 0) {
            $('[data-plugins="dropify"]').dropify({
                messages: {
                    'default': 'Geser dan jatuhkan gambar atau klik saja',
                    'replace': 'Geser dan jatuhkan atau klik saja untuk mengganti',
                    'remove': 'hapus',
                    'error': 'Ooops, kamu salah.'
                },
                error: {
                    'fileSize': 'Ukuran file terlalu besar.'
                }
            });
        };
        $('input[name="keyword"]').selectize({
            persist: false,
            createOnBlur: true,
            create: true
        });
    });
</script>
@endsection