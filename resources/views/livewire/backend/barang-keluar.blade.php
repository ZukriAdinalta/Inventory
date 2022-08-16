<div>
    <div class="card border-success">
        <div class="card-header">
            Barang Keluar
        </div>
        <div class="card-body">
            <div class="notifikasi">
                @if (session()->has('pesan'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('pesan') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @elseif (session()->has('hapus'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('hapus') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif
            </div>
            <div class="create">
                @if ($this->create == true || $this->update == true)
                <button wire:click='Close' type="button" class="btn btn-secondary border">
                    <li class="fas fa-minus"></li>
                </button>
                <form>
                    <div class="card mt-1 border-warning">
                        <div class="card-body">
                            <form>
                                <div class="row justify-content-strat mt-1">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label for="kode">Kode Inventaris <span class="text-danger">*</span></label>
                                            <select wire:model='inven_id'
                                                class="form-control form-select  @error('inven_id') is-invalid @enderror"
                                                id="inven_id" required {{ $this->update == true ? 'disabled' :'' }}>
                                                <option value="">Pilih Jenis Barang</option>
                                                @foreach ($Inventaris as $inventaris)
                                                @if ($inventaris->id)
                                                <option value="{{ $inventaris->id }}" selected>{{
                                                    $inventaris->k_inven }}
                                                </option>
                                                @else
                                                <option value="{{ $inventaris->id }}">{{ $inventaris->k_inven}}
                                                </option>
                                                @endif
                                                @endforeach
                                            </select>
                                            @error('inven_id')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nambar">Jenis Barang</label>
                                            <p>{{ $this->jenbar }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nambar">Nama Barang</label>
                                            <p>{{ $this->nambar }}</p>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nambar">Tanggal <span class="text-danger">*</span></label>
                                            <input type="date" wire:model='tgl_keluar'
                                                class="form-control @error('tgl_keluar') is-invalid @enderror"
                                                id="kode">
                                            @error('tgl_keluar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                        @error('tgl_keluar')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                        @enderror
                                    </div>
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label for="nambar">Barang Keluar <span class="text-danger">*</span></label>
                                            <input type="number" wire:model='jumlah_keluar'
                                                class="form-control @error('jumlah_keluar') is-invalid @enderror"
                                                id="kode">
                                            @error('jumlah_keluar')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-md-1">
                                        <div class="form-group">
                                            <label for="nambar">Total</label>
                                            <p>{{ $this->total }}</p>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal-footer mb-0">
                                    @if ($this->update == true)
                                    <button wire:click.prevent='Update({{ $this->id_keluar }})'
                                        class="btn btn-primary">Update</button>
                                    @else
                                    <button wire:click.prevent='Simpan' class="btn btn-primary">Simpan</button>
                                    @endif
                                </div>
                            </form>
                        </div>
                    </div>
                </form>
                @else
                <button wire:click='Create' type="button" class="btn btn-success border">
                    <li class="fas fa-plus"></li>
                </button>
                @endif
            </div>
            <div class="row mb-2 justify-content-end mt-1">
                <div class="col-md-6">
                    <select wire:model='perpage' class="form-control w-auto">
                        <option value="10" selected>10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                    </select>
                </div>
                <div class="col-sm-6">
                    <div class="input-group">
                        <input wire:model="search" type="text" class="form-control bg-light border-0 small"
                            placeholder="Search...">
                        <div class="input-group-append">
                            <span class="btn btn-primary ">
                                <i class="fas fa-search fa-sm"></i>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <table class="table table-hover table-striped ">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Kode Inventaris</th>
                        <th>Nama Jenis</th>
                        <th>Nama Barang</th>
                        <th>Barang Keluar</th>
                        <th>Tanggal Keluar</th>
                        <th>Petugas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $BarangKeluar->firstItem()  ?>
                    @foreach ($BarangKeluar as $BK)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $BK->Inven->k_inven }}</td>
                        <td>{{ $BK->jenbar }}</td>
                        <td>{{ $BK->nambar }}</td>
                        <td class="text-center">{{ $BK->jumlah_keluar }}</td>
                        <td class="text-center">{{ date('d M Y', strtotime( $BK->tgl_keluar)) }}</td>
                        <td>{{ $BK->User->nama }}</td>
                        <td><a wire:click="Edit({{ $BK->id }}) " type="button" data-toggle="modal"
                                data-target="#create"><i class="fas fa-pen text-primary"></i></a>
                            |
                            <a wire:click="DeleteData({{ $BK->id }}) " type="button"><i
                                    class=" fas fa-trash text-danger" data-toggle="modal" data-target="#delete"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @if ($BarangKeluar->firstItem() == 0)
                    <tr>
                        <td colspan="8" class="text-center">Data Kosong</td>
                    </tr>
                    @endif
                </tbody>
            </table>
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
        </div>
    </div>
    {{-- Modal Delete --}}
    <div wire:ignore.self class="modal fade" id="delete" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content text-white bg-danger border-primary">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Delete</h5>
                    <button wire:click='Close' type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body justify-content-center">
                    <input wire:model="id_inven" type="hidden">
                    <p class="col-form-label">Yakin Hapus Barang Keluar:</p>
                    <table class="justify-content-start">
                        <tr>
                            <th>Kode</th>
                            <td> : {{ $this->inven_id }}</td>
                            <th>| Jenis Barang</th>
                            <td> : {{ $this->jenbar}}</td>
                        </tr>
                        <tr>
                            <th>Nama Barang:</th>
                            <td style="width: 30%"> {{ $this->nambar}}</td>
                            <th>| Barang Keluar </th>
                            <td> : {{ $this->jumlah_keluar}}</td>
                        </tr>
                    </table>
                </div>
                <div class="modal-footer">
                    <button wire:click='Close' type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"
                        wire:click.prevent="Delete({{ $this->id_keluar }})">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>