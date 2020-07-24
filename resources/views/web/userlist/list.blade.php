
@extends('layouts.vertical', ['title' => 'User'])

@section('css')
<link href="{{asset('assets/libs/bootstrap-table/bootstrap-table.min.css')}}" rel="stylesheet" type="text/css" />
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
                            <li class="breadcrumb-item active">User</li>
                        </ol>
                    </div>
                    <h4 class="page-title">User</h4>
                </div>
            </div>
        </div>     
        <!-- end page title --> 
        @if(session()->get('msg'))
            {!! session()->get('msg') !!}
        @endif
        <div class="row ">
            <div class="col-sm-12">
                <form class="float-xl-right float-lg-right" method="GET" action="{{ route('userlist.show') }}">
                    @method('GET')
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <input type="text" class="form-control input-sm mb-2" id="inlineFormInput" name="query" placeholder="Cari sesuatu" value="{{ request()->get('query') }}">
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-dark btn-sm waves-effect waves-light mb-2"><i class="fe-search mr-1"></i>Cari</button>
                        </div>
                    </div>
                </form>
                <form class="exe" method="POST" action="{{ route('userlist.deletemass') }}">
                    @csrf
                    @method('POST')
                    <div class="form-row align-items-center">
                        <div class="col-auto">
                            <select name="pilihexe" class="custom-select input-sm mb-2">
                                <option value="">Pilih Aksi</option>
                                <option value="1">Hapus</option>
                            </select>
                            <input type="hidden" name="ids"/>
                        </div>
                        <div class="col-auto">
                            <button type="submit" class="btn btn-dark btn-sm waves-effect waves-light mb-2">Eksekusi</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12">
                <div class="card-box">
                    <table id="demo-custom-toolbar"  data-toggle="table"
                            data-search="false"
                            data-show-refresh="false"
                            data-show-columns="false"
                            data-sort-name="id"
                            data-pagination="false" data-show-pagination-switch="false" class="table-borderless">
                        <thead class="thead-light">
                        <tr>
                            <th>
                                <div class="checkbox checkbox-dark checkbox-single">
                                    <input type="checkbox" class="cekall">
                                    <label></label>
                                </div>
                            </th>
                            <th data-field="name" data-sortable="false">Nama</th>
                            <th data-field="email" data-sortable="false">Email</th>
                            <th>Role</th>
                            <th>Tanggal</th>
                            <th >Aksi</th>
                        </tr>
                        </thead>

                        <tbody>
                            @foreach($lists as $key => $list)
                                <tr>
                                    <td>
                                        <div class="checkbox checkbox-dark checkbox-single">
                                            <input type="checkbox" name="ceking" data-id="{{ $list->id }}">
                                            <label></label>
                                        </div>
                                    </td>
                                    <td>{{ $list->name }}</td>
                                    <td>{{ $list->email }}</td>
                                    <td>
                                        {{ $list->role }}
                                    </td>
                                    <td>
                                        {{ $list->created_at->diffForHumans() }}
                                    </td>
                                    <td>
                                        <form action="{{ route('userlist.destroy', $list->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <a class="btn btn-success btn-sm" href="{{ route('userlist.edit',$list->id) }}">Edit</a>
                                            <button type="submit" class="btn btn-sm btn-danger">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div> <!-- end card-box-->
            </div> <!-- end col-->
        </div>
        <div class="row">
            <div class="col-sm-12">
                {{ $lists->withQueryString()->links() }}
            </div>
        </div>
        <!-- end row-->
        
    </div> <!-- container -->
@endsection

@section('script')
<!-- Plugins js-->
<script src="{{asset('assets/libs/bootstrap-table/bootstrap-table.min.js')}}"></script>

<!-- Page js-->
<script src="{{asset('assets/js/pages/bootstrap-tables.init.js')}}"></script>
<script>
    $(document).ready(function(){
        $('.cekall').change(function(){
            if($(this).is(':checked', true))
            {
                $('input[name="ceking"]').prop('checked', true);
            }else{
                $('input[name="ceking"]').prop('checked', false);
            }
        })
        $('input[name="ceking"]').change(function(){
            if($('input[name="ceking"]:checked').length == $('input[name="ceking"]').length)
            {
                $('.cekall').prop('checked', true);
            }else{
                $('.cekall').prop('checked', false);
            }
        });
        $('form.exe').submit(function(e){
            var hasil = $('select[name="pilihexe"]').val();
            if(hasil == 1)
            {
                var arr = [];
                $('input[name="ceking"]:checked').each(function(){
                    arr.push($(this).attr('data-id'));
                });
                if(arr.length > 0)
                {
                    var strarr = arr.join(',');
                    $('input[name="ids"]').val(strarr);
                    $(this).submit();
                }else{
                    e.preventDefault();
                }
            }else{
                e.preventDefault();
            }
        });
    });
</script>
@endsection