<div>
    <div class="card border-success">
        <h5 class="card-header">Laporan</h5>
        <div class="card-body">
            <div class="notifikasi">
                @if (session()->has('pesan'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('pesan') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
            <form>
                <div class="row d-flex justify-content-center">
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-form-label">Tanggal</label>
                            <input wire:model='tgl_awal' type="date"
                                class="form-control  @error('tgl_awal') is-invalid @enderror">
                            @error('tgl_awal')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label for="inputEmail3" class="col-form-label">Tanggal Akhir</label>
                            <input wire:model='tgl_akhir' type="date"
                                class="form-control  @error('tgl_akhir') is-invalid @enderror">
                            @error('tgl_akhir')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label for="inputEmail3" class="col-form-label">Manager</label>
                            <select wire:model='manager' class="form-control  @error('manager') is-invalid @enderror"
                                id="exampleFormControlSelect1">
                                <option value="">Pilih Manager</option>
                                @foreach ($Manager as $K)
                                @if ($K->id)
                                <option value="{{ $K->nama }}" selected>{{ $K->nama }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('manager')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label for="inputEmail3" class="col-form-label">Kepala Gudang</label>
                            <select wire:model='kegud' class="form-control  @error('kegud') is-invalid @enderror"
                                id="exampleFormControlSelect1">
                                <option value="">Pilih Kepala Gudang</option>
                                @foreach ($Kegud as $K)
                                @if ($K->id)
                                <option value="{{ $K->nama }}" selected>{{ $K->nama }}</option>
                                @endif
                                @endforeach
                            </select>
                            @error('kegud')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group ">
                            <label for="inputEmail3" class="col-form-label">Manager</label>
                            <select wire:model='kategori' class="form-control  @error('kategori') is-invalid @enderror"
                                id="exampleFormControlSelect1">
                                <option value="">Kategori</option>
                                <option value="b_masuk">Barang Masuk</option>
                                <option value="b_keluar">Barang Keluar</option>
                            </select>
                            @error('kategori')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="form-group">
                            <label for="inputEmail3" class="col-form-label">Aksi</label>
                            <div>
                                @if (auth()->user()->level == 2)
                                <button wire:click.prevent='Filter' type="submit"
                                    class="btn btn-warning">Filter</button>
                                @endif
                                <button wire:click.prevent='Export' type="submit" class="btn btn-primary">Cetak</button>
                            </div>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>

    @if ($this->filter == true)
    <div class="card border-warning mt-3">
        <div class="card-header">
            <button wire:click='resetForm' class="btn-secondary">
                <li class="fa fa-minus"></li>
            </button>
        </div>
        <div class="card-body">
            <div class="row mb-2 justify-content-end mt-1">
                <div class="col-md-12">
                    <select wire:model='perpage' class="form-control w-auto">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
            </div>
            <table class="table table-hover table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Inventaris</th>
                        <th>Nama Jenis</th>
                        <th>Nama Barang</th>
                        <th>{{ $this->kategori == 'b_masuk' ? 'Barang Masuk' : 'Barang Keluar'}}</th>
                        <th>Stok Barang</th>
                        <th>Tanggal Keluar</th>
                        <th>Petugas</th>
                    </tr>
                </thead>
                @if ($this->kategori == 'b_masuk')
                <tbody>
                    <?php $no = $BarangMasuk->firstItem()  ?>
                    @foreach ($BarangMasuk as $BM)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $BM->Inven->k_inven }}</td>
                        <td>{{ $BM->jenbar }}</td>
                        <td>{{ $BM->nambar }}</td>
                        <td class="text-center">{{ $BM->jumlah_masuk }}</td>
                        <td class="text-center">{{ $BM->Inven->jumlah }}</td>
                        <td class="text-center">{{ date('d M Y', strtotime( $BM->tgl_masuk)) }}</td>
                        <td>{{ $BM->User->nama }}</td>
                    </tr>
                    @endforeach
                    @if ($BarangMasuk->firstItem() == 0)
                    <tr>
                        <td colspan="8" class="text-center">Data Kosong</td>
                    </tr>
                    @endif
                </tbody>
                @elseif ($this->kategori == 'b_keluar')
                <tbody>
                    <?php $no = $BarangKeluar->firstItem()  ?>
                    @foreach ($BarangKeluar as $BK)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $BK->Inven->k_inven }}</td>
                        <td>{{ $BK->jenbar }}</td>
                        <td>{{ $BK->nambar }}</td>
                        <td class="text-center">{{ $BK->jumlah_keluar }}</td>
                        <td class="text-center">{{ $BK->Inven->jumlah }}</td>
                        <td class="text-center">{{ date('d M Y', strtotime( $BK->tgl_keluar)) }}</td>
                        <td>{{ $BK->User->nama }}</td>
                    </tr>
                    @endforeach
                    @if ($BarangKeluar->firstItem() == 0)
                    <tr>
                        <td colspan="8" class="text-center">Data Kosong</td>
                    </tr>
                    @endif
                </tbody>
                @endif
            </table>
            @if ($this->kategori == 'b_keluar')
            <div class="row">
                <div class="col-md-5 d-flex align-items-center ">
                    <p>
                        Showing {{ $BarangKeluar->firstItem() }} to {{ $BarangKeluar->lastItem() }} of {{
                        $BarangKeluar->total() }}
                        entries
                    </p>
                </div>
                <div class="col-md-7">
                    <p>
                        {{ $BarangKeluar->links() }}
                    </p>
                </div>
            </div>
            @elseif($this->kategori == 'b_masuk')
            <div class="row">
                <div class="col-md-5 d-flex align-items-center ">
                    <p>
                        Showing {{ $BarangMasuk->firstItem() }} to {{ $BarangMasuk->lastItem() }} of {{
                        $BarangMasuk->total() }}
                        entries
                    </p>
                </div>
                <div class="col-md-7">
                    <p>
                        {{ $BarangMasuk->links() }}
                    </p>
                </div>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>