@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header" style="background: white">
                    <h5 class="card-title fw-semibold mb-4">Proses Perhitungan</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('transaksi.filter') }}" method="GET">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="row align-items-center">
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="first-date">Tanggal Dari</label>
                                        <input type="date" id="first-date" required class="form-control mt-2"
                                            name="tanggal_dari" required />
                                    </div>
                                    <div class="col-md-4 form-group mb-3">
                                        <label for="second-date">Tanggal Sampai</label>
                                        <input type="date" id="second-date" required class="form-control mt-2"
                                            name="tanggal_sampai" required />
                                    </div>
                                    {{-- <button type="submit" class="col-md-3 btn btn-primary mt-2"
                                        style="height: 50%">Cari</button> --}}
                                </div>
                                <h5><em>Range Min Coffidance: 0.10-1.00</em></h5>
                                <h5><em>Jumlah Data: {{ $totalTransactions ?? '' }} </em></h5>
                            </div>
                            <div class="col-md-6">
                                <div class="col-md-4 form-group mb-3">
                                    <label for="first-date">Min Support</label>
                                    <input type="text" id="first-date" required class="form-control mt-2"
                                        name="min_support" required />
                                </div>
                                <div class="col-md-4 form-group mb-3">
                                    <label for="first-date">Min Confidance</label>
                                    <input type="text" id="first-date" required class="form-control mt-2"
                                        name="min_confidance" required />
                                </div>
                                <button type="submit" class="btn btn-primary">Proses Data</button>
                            </div>
                    </form>
                </div>
                {{-- @if (isset($transaksi) && count($transaksi) > 0)
                    <div class="table-responsive mt-4">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">No</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Tanggal Transaksi</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Obat</h6>
                                    </th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($transaksi as $item)
                                    <tr>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0">{{ $loop->iteration }}</h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-1">
                                                {{ \Carbon\Carbon::parse($item->tanggal_transaksi)->format('d F Y') }}
                                            </h6>
                                        </td>
                                        <td class="border-bottom-0">
                                            <ul>
                                                @foreach ($item->detail as $detail)
                                                    <li>{{ $detail->obat->nama }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="mt-4 text-center">Tidak ada data yang ditemukan.</p>
                @endif --}}
                @if (isset($rules))
                    <table class="table table-bordered mt-3">
                        <thead>
                            <tr>
                                <th>Itemset</th>
                                <th>Support</th>
                                <th>Confidence</th>
                                <th>Lift Ratio</th>
                                <th>Lolos</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rules as $rule)
                                <tr>
                                    <td>{{ implode(', ', explode(',', $rule['itemset'])) }}</td>
                                    <td>{{ $rule['support'] }}</td>
                                    <td>{{ $rule['confidence'] }}</td>
                                    <td>{{ $rule['liftRatio'] }}</td>
                                    <td>{{ $rule['keterangan'] }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="mt-4 text-center"></p>
                @endif

                @if (isset($dataVertikal))
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Obat ID</th>
                                @foreach ($transaksi as $trans)
                                    <th>Transaksi {{ $trans->id }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($rules as $rule)
                                @foreach ($dataVertikal as $obat_id => $transactions)
                                    <tr>
                                        <td>{{ $obat_id }}</td>
                                        @foreach ($transactions as $trans_id => $value)
                                            <td>{{ $value }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                            @endforeach
                        </tbody>
                    </table>
                @else
                    <p class="mt-4 text-center"></p>
                @endif
            </div>
        </div>
    </div>
    @if (session('message'))
        <div class="alert alert-info">
            {{ session('message') }}
        </div>
    @endif
@endsection
