@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header mb-3">
                    <div class="mb-4">
                        <h5 class="card-title fw-semibold">Detail Perhitungan Eclat</h5>
                    </div>
                    <ul class="timeline-widget mb-0 position-relative mb-n5">
                        <li class="timeline-item d-flex position-relative overflow-hidden">
                            <div class="timeline-desc text-dark">Rentang tanggal
                                :
                                {{ \Carbon\Carbon::parse($calculation->tanggal_dari)->format('d F Y') }} -
                                {{ \Carbon\Carbon::parse($calculation->tanggal_sampai)->format('d F Y') }}</d>
                                <div class="timeline-desc text-dark ">Min. Support :
                                    {{ $calculation->min_support }}
                                </div>
                                <div class="timeline-desc text-dark ">Min.Confidance :
                                    {{ $calculation->min_confidance }}</div>
                            </div>
                        </li>
                    </ul>
                </div>
                <div class="card-body p-4">

                    <div class="table-responsive">
                        <table class="table text-nowrap mb-0 align-middle" id="myTable">
                            <thead class="text-dark fs-4">
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Obat</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Itemset</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jumlah Item</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Support</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Confidance</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Lift Ratio</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Keterangan</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($calculation->results as $result)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">
                                                {{ $result->details->pluck('obat.nama')->join(', ') }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $result->itemset }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $result->result_type }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">
                                                {{ $result->support }}
                                            </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">
                                                {{ $result->confidence }}
                                            </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">
                                                {{ $result->lift_ratio }}
                                            </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">
                                                {{ $result->keterangan }}
                                            </h6>
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
