<!DOCTYPE html>
<html lang="en" data-bs-theme="">

<head>
    <meta charset="utf-8">
    <title>THEMosque - Mosque Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="" name="keywords">
    <meta content="" name="description">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Open+Sans:wght@300;400;500;600;700&family=Pacifico&display=swap"
        rel="stylesheet">
    <!-- Icon Font Stylesheet -->
    <link rel="stylesheet" href="{{ url('assets/css/all.css') }}" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <!-- Libraries Stylesheet -->
    <link href="{{ url('assets/lib/animate/animate.min.css') }}" rel="stylesheet">
    <link href="{{ url('assets/lib/owlcarousel/assets/owl.carousel.min.css') }}" rel="stylesheet">
    <!-- Customized Bootstrap Stylesheet -->
    <link href="{{ url('assets/css/bootstrap.min.css') }}" rel="stylesheet">

    <!-- Template Stylesheet -->
    <link href="{{ url('assets/css/style.css') }}" rel="stylesheet">
    <style>
        .modal-backdrop {
            z-index: -1;
        }
    </style>
    <style>
        .preload {
            position: absolute;
            top: 50%;
            left: 50%;
            color: #F1C152;
        }
    </style>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body>
    <div class="spinner-grow spinner-grow preload d-none" role="status">
        <span class="visually-hidden">Loading...</span>
    </div>
    <!-- Hero Start -->
    <div class="container-fluid hero-header">
        <div class="container">
            <div class="row">
                <div class="col">
                    <div class="hero-header-inner wow fadeIn shadow text-center">
                        <h4 class="fs-4 text-dark">Dzuhur</h4>
                        <p class="mb-5 text-dark" id="dzuhur"></p>
                    </div>
                </div>
                <div class="col">
                    <div class="hero-header-inner wow fadeIn shadow text-center">
                        <h4 class="fs-4 text-dark">Ashar</h4>
                        <p class="mb-5 text-dark" id="ashar"></p>
                    </div>
                </div>
                <div class="col">
                    <div class="hero-header-inner wow fadeIn shadow text-center">
                        <h4 class="fs-4 text-dark">Maghrib</h4>
                        <p class="mb-5 text-dark" id="maghrib"></p>
                    </div>
                </div>
                <div class="col">
                    <div class="hero-header-inner wow fadeIn shadow text-center">
                        <h4 class="fs-4 text-dark">Isyak</h4>
                        <p class="mb-5 text-dark" id="isyak"></p>
                    </div>
                </div>
            </div>
            <div class="row mt-3">
                <div class="col">
                    <div class="hero-header-inner wow fadeIn shadow text-center">
                        <h4 class="fs-4 text-dark">Subuh</h4>
                        <p class="mb-5 text-dark" id="subuh"></p>
                    </div>
                </div>
                <div class="col">
                    <div class="hero-header-inner wow fadeIn shadow text-center">
                        <h4 class="fs-4 text-dark">Terbit</h4>
                        <p class="mb-5 text-dark" id="terbit"></p>
                    </div>
                </div>
                <div class="col">
                    <div class="hero-header-inner wow fadeIn shadow text-center">
                        <h4 class="fs-4 text-dark">Dhuha</h4>
                        <p class="mb-5 text-dark" id="dhuha"></p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <h1 class="wib text-dark text-center bg-light mt-4  wow fadeIn">15:55 WIB</h1>
                </div>
            </div>
            <div class="row mt-2">
                <div class="col">
                    <table class="table text-dark fw-bold bg-light  wow fadeIn">
                        <tr class="text-center">
                            <td>LOKASI SAAT INI <span id="location"></span></td>
                        </tr>
                        <tr class="text-center">
                            <td>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#modalLokasi">
                                    Lokasi
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#alarm">
                                    Alarm
                                </button>
                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#kalender">
                                    Kalender
                                </button>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Hero End -->
    {{-- modal lokasi --}}
    <div class="modal fade text-center" id="modalLokasi" tabindex="-1" aria-labelledby="modalLokasi"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div class="input-group mb-3">
                        <input type="text" class="form-control" name="inputLokasi" id="inputLokasi"
                            aria-label="Cari kota anda" placeholder="Cari kota anda">
                        <button class="input-group-text" id="btnSearchLocation">
                            <i class="bi bi-search"></i>
                        </button>
                    </div>
                    <div id="loadingLocation"></div>
                    <div id="radioContainer"></div>
                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" id="btnSetLocation" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{-- end modal lokasi --}}
    {{-- modal alarm --}}
    <div class="modal fade text-center" id="alarm" tabindex="-1" aria-labelledby="alarm" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <table class="table table-borderless table-responsive">
                        <thead>
                            <tr>
                                <th>Label</th>
                                <th>Alarm</th>
                                <th>Perulangan</th>
                            </tr>
                        </thead>
                        <tbody id="tableAlarm"></tbody>
                    </table>
                    <div class="mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                            data-bs-target="#addAlarm">Tambah</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('addAlarmModal')
    {{-- end modal alarm --}}
    {{-- modal hijriyah --}}
    <div class="modal fade text-center" id="kalender" tabindex="-1" aria-labelledby="kalender"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <p>on going</p>
                    {{-- <div class="mt-3">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-primary">Simpan</button>
                    </div> --}}
                </div>
            </div>
        </div>
    </div>
    {{-- end modal hijriyah --}}

    <!-- JavaScript Libraries -->
    <script src="{{ url('assets/lib/jquery.min.js') }}"></script>
    <script src="{{ url('assets/lib/bootstrap.bundle.min.js') }}"></script>
    @stack('js')
</body>

</html>
