@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header" style="background: white">
                    <h5 class="card-title fw-semibold mb-4">Table Hasil</h5>
                    <p class="mt-3">Jumlah Data : {{ $count }}</p>
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
                                        <h6 class="fw-semibold mb-0">Rentang Tanggal</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Min Support</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Min Confidance</h6>
                                    </th>

                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($calculations as $calculation)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">
                                                {{ \Carbon\Carbon::parse($calculation->tanggal_dari)->format('d F Y') }} -
                                                {{ \Carbon\Carbon::parse($calculation->tanggal_sampai)->format('d F Y') }}
                                            </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{ $calculation->min_support }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <p class="mb-0 fw-normal">
                                                {{ $calculation->min_confidance }}
                                            </p>
                                        </td>
                                        <td class="border-bottom-0">
                                            <a href="{{ route('hasil.detail', $calculation->id) }}"
                                                class="btn btn-primary"><i class="ti ti-info-circle"></i></a>
                                            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target=""><i
                                                    class="ti ti-file-text"></i></button>
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
