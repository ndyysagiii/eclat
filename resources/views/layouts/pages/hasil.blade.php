@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header" style="background: white">
                    <h5 class="card-title fw-semibold mb-4">Table Hasil</h5>
                    <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#add">Tambah
                        Data</button>
                    <p class="mt-3">Jumlah Data : {{ $obatCount }}</p>
                </div>
                <div class="card-body p-4">
                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="myTable">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Nama Obat</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($obat as $item)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">{{ $item->nama }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{ \Carbon\Carbon::parse($item->created_at)->format('d F Y') }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <button class="btn icon btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#update{{ $item->id }}"><i
                                                    class="ti ti-edit"></i></button>
                                            <button class="btn icon btn-danger" data-bs-toggle="modal"
                                                data-bs-target="#delete{{ $item->id }}"><i
                                                    class="ti ti-trash"></i></button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
