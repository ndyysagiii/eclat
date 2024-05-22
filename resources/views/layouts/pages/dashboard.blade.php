@extends('layouts.main')

@section('content')
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-12 d-flex align-items-stretch">
                <div class="card w-100">
                    <div class="card-body p-4">
                        <div class="mb-4">
                            <h5 class="card-title fw-semibold">Alur Pengolahan</h5>
                        </div>
                        <ul class="timeline-widget mb-0 position-relative mb-n5">
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border border-primary flex-shrink-0 my-8"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <a href="#" class="btn btn-primary fs-3 ms-3">Data Transaksi</a>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Mengisi Data Transaksi
                                            sebelum melakukan penilaian ,mengisi data transaksi terlebih dahulu,
                                            kemudian isi dengan lengkap lalu simpan, setelah selesai langsung
                                            melakukan peritungan pada form proses algoritma.</div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <a href="" class="btn btn-primary">Tambah Transaksi</a>
                                    </div>
                                </div>
                            </li>
                            <li class="timeline-item d-flex position-relative overflow-hidden">
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border border-info flex-shrink-0 my-8"></span>
                                    <span class="timeline-badge-border d-block flex-shrink-0"></span>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <a href="#" class="btn btn-primary fs-3 ms-3">Proses Algoritma</a>
                                        <div class="timeline-desc fs-3 text-dark mt-n1">Melakukan Penilaian
                                            Lakukan perhitungan pada data transaksi,untuk melihat dua atau tiga
                                            item
                                            yang sering muncul atau sering dibeli secara bersamaan, Isi rentang
                                            tanggalyang diinginkan, kemudian isi nilai minimum support dan min
                                            cofidance,lalu klik proses</div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <a href="" class="btn btn-primary">Proses
                                            Algoritma</a>
                                    </div>
                                </div>

                            </li>
                            <li class="timeline-item d-flex position-relative overflow-hidden mb-3">
                                <div class="timeline-badge-wrap d-flex flex-column align-items-center">
                                    <span class="timeline-badge border-2 border border-info flex-shrink-0 my-8"></span>
                                </div>
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <a href="#" class="btn btn-primary fs-3 ms-3">Hasil</a>
                                        <div class="timeline-desc fs-3 text-dark mt-n1 mb-5">Hasil
                                            Setelah selsai semua,kita dapat melihat hasil proses,dengan
                                            mengeklik
                                            lihat detail pada tabel detail, didalam form detail nantinya akan
                                            menampilkan data itemset dari 2 dan 3 barang yang berisi keterangan
                                            korelasi lolos atau tidaknya.</div>
                                    </div>
                                    <div class="col-md-2 text-center">
                                        <a href="" class="btn btn-primary">Lihat Hasil</a>
                                    </div>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
