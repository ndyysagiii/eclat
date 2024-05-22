@extends('layouts.main')
@push('scripts')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
@endpush
@section('content')
    <div class="container-fluid">
        <div class="col-lg-12 d-flex align-items-stretch">
            <div class="card w-100">
                <div class="card-header" style="background: white">
                    <h5 class="card-title fw-semibold mb-4">Table Transaksi</h5>
                    <button class="btn btn-primary me-3" data-bs-toggle="modal" data-bs-target="#add">Tambah
                        Data</button>
                    <p class="mt-3">Jumlah Data : {{ $transaksiCount }}</p>
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
                                        <h6 class="fw-semibold mb-0">Tanggal Transaksi</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Jenis Obat</h6>
                                    </th>
                                    <th class="border-bottom-0">
                                        <h6 class="fw-semibold mb-0">Aksi</h6>
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
                                            <ul class="list-unstyled">
                                                @foreach ($item->detail as $detail)
                                                    <li>{{ $detail->obat->nama }}</li>
                                                @endforeach
                                            </ul>
                                        </td>
                                        <td class="border-bottom-0">
                                            <h6 class="fw-semibold mb-0 fs-4">
                                                <button class="btn icon btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#update{{ $item->id }}"><i
                                                        class="ti ti-edit"></i></button>
                                                <button class="btn icon btn-danger" data-bs-toggle="modal"
                                                    data-bs-target="#delete{{ $item->id }}"><i
                                                        class="ti ti-trash"></i></button>
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

    {{-- modal add --}}
    <div class="modal fade text-left" id="add" tabindex="-1" role="dialog" aria-labelledby="myModalLabel1"
        data-bs-backdrop="false" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel1">Tambah Data</h5>
                </div>
                <form action="{{ route('transaksi.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="form-group mb-3">
                            <label for="first-name-vertical">Tanggal Transaksi</label>
                            <input type="date" id="first-name-vertical" required class="form-control"
                                name="tanggal_transaksi" required />
                        </div>
                        <div class="form-group">
                            <label for="obat_id">Nama Obat</label>
                            <select id="obat_id" class="form-select" style="width: 100%" name="obat[]"
                                multiple="multiple" required>
                                @foreach ($obat as $item)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn" data-bs-dismiss="modal">
                            <i class="bx bx-x d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Tutup</span>
                        </button>
                        <button type="submit" class="btn btn-primary ms-1">
                            <i class="bx bx-check d-block d-sm-none"></i>
                            <span class="d-none d-sm-block">Simpan</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    {{-- modal update --}}
    @foreach ($transaksi as $item)
        <div class="modal fade text-left" id="update{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Edit Data</h5>
                    </div>
                    <form action="{{ route('transaksi.update', $item->id) }}" method="post">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="form-group mb-3">
                                <label for="first-name-vertical">Tanggal Transaksi</label>
                                <input type="date" id="first-name-vertical" required class="form-control"
                                    name="tanggal_transaksi" value="{{ $item->tanggal_transaksi }}" required />
                            </div>
                            <div class="form-group">
                                <label for="obat_id{{ $item->id }}">Nama Obat</label>
                                <select id="obat_id{{ $item->id }}" class="form-select" style="width: 100%"
                                    name="obat[]" multiple="multiple" required>
                                    @foreach ($obat as $o)
                                        <option value="{{ $o->id }}"
                                            {{ in_array($o->id, $item->detail->pluck('obat_id')->toArray()) ? 'selected' : '' }}>
                                            {{ $o->nama }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- modal delete --}}
    @foreach ($transaksi as $item)
        <div class="modal fade text-left" id="delete{{ $item->id }}" tabindex="-1" role="dialog"
            aria-labelledby="myModalLabel1" data-bs-backdrop="false" aria-hidden="true">
            <div class="modal-dialog modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel1">Hapus Data </h5>

                    </div>
                    <form action="{{ route('transaksi.delete', $item->id) }}" method="post">
                        @csrf
                        @method('DELETE')
                        <div class="modal-body">
                            Apakah anda yakin untuk menghapus data ?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn" data-bs-dismiss="modal">
                                <i class="bx bx-x d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Tutup</span>
                            </button>
                            <button type="submit" class="btn btn-primary ms-1">
                                <i class="bx bx-check d-block d-sm-none"></i>
                                <span class="d-none d-sm-block">Simpan</span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    @endforeach
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $('#obat_id').select2({
                placeholder: 'Cari Obat',
                dropdownParent: $('#add')
            });
        });
    </script>
    @foreach ($transaksi as $item)
        <script>
            $(document).ready(function() {
                $('#obat_id{{ $item->id }}').select2({
                    placeholder: 'Cari Obat',
                    dropdownParent: $('#update{{ $item->id }}')
                });
            });
        </script>
    @endforeach
@endpush
