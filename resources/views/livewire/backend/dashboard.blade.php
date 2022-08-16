<div>
    <!-- Content Row -->
    <div class="row">
        @if (auth()->user()->level == 1)
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-primary shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                Pengguna</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $User->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fas fa-users fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-success shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                Inventaris</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $Inven->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class="fa fa-boxes fa-2x text-gray-300"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Earnings (Monthly) Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card  border-left-info shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                                Barang Masuk</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $BM->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class=" fa fa-box fa-2x text-gray-300"></i>
                            <sup><i class=" fas fa-plus  text-gray-300"></i></sup>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Pending Requests Card Example -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card border-left-warning shadow h-100 py-2">
                <div class="card-body">
                    <div class="row no-gutters align-items-center">
                        <div class="col mr-2">
                            <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                                Barang Keluar</div>
                            <div class="h5 mb-0 font-weight-bold text-gray-800">{{ $BK->count() }}</div>
                        </div>
                        <div class="col-auto">
                            <i class=" fa fa-box fa-2x text-gray-300"></i>
                            <sup> <i class=" fas fa-minus  text-gray-300"></i></sup>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>