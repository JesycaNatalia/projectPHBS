@extends('admin.layouts.dashboard')

@section('title', 'Edit Jawaban')

@section('style')
@endsection

@section('content')
<div class="content-header row">
    <div class="content-header-left col-12 mb-2 mt-1">
        <div class="breadcrumbs-top">
            <h5 class="content-header-title float-left pr-1 mb-0">Jawaban</h5>
            <div class="breadcrumb-wrapper d-none d-sm-block">
                <ol class="breadcrumb p-0 mb-0 pl-1">
                    <li class="breadcrumb-item"><a href="index.html"><i class="bx bx-home-alt"></i></a>
                    </li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard.jawaban.index') }}">Tabel
                            Jawaban</a>
                    </li>
                    <li class="breadcrumb-item active">Edit Jawaban
                    </li>
                </ol>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-8">
        <div class="card">
            <form action="{{ route('admin.dashboard.jawaban.update', $isi_kuisoner->id) }}" method="POST"
                enctype="multipart/form-data">
                <div class="card-header">
                    <p class="card-title font-weight-bold">Form Edit Jawaban</p>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group mb-50">
                                <div class="form-group mb-50">
                                    <label class="text-bold-600">Jawaban <span class="text-danger">*</span></label>
                                    <input type="text" name="jawaban" id="title" class="form-control"
                                        placeholder="e.g: Sering" required value="{{ $isi_kuisoner->jawaban }}">
                                </div>
                            </div>
                            <div class="form-group mb-50">
                                <div class="form-group mb-50">
                                    <label class="text-bold-600">Skor <span class="text-danger">*</span></label>
                                    <input type="number" name="skor" id="title" class="form-control"
                                        placeholder="e.g: 3" required value="{{ $isi_kuisoner->skor }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @csrf
                @method('PUT')
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