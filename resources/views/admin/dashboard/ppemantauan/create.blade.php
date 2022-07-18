@extends('admin.layouts.dashboard')

@section('title', 'Tambah Jenis Pemantauan')

@section('style')
<style>
    .ck-editor__editable_inline {
        min-height: 200px;
    }
</style>
@endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0"> Jenis Pemantauan</h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.pilihpemantauan.index')}}"><i class="fa-solid fa-circle-arrow-left"></i></a>
                    </li>
                    <li class="breadcrumb-item active">Tambah Jenis Pemantauan
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('admin.dashboard.pilihpemantauan.store') }}" method="POST">
                <div class="card-header">
                    <p class="card-title font-weight-bold">Form Tambah Jenis Pemantauan</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-50">
                                <div class="form-group mb-50">
                                    <label class="text-bold-600">Jenis Pemantauan <span class="text-danger">*</span></label>
                                    <input type="text" name="namapemantauan" id="title" class="form-control" placeholder="e.g: Pemantauan Hidup Bersih dan Sehat" required>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
                <div class="card-footer">
                    <button type="submit" class="btn btn-success float-right mb-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Simpan</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
@endsection