<div>
    <div class="card border-success">
        <div class="card-header">
            Inventaris
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
                    <div class="row mb-2 justify-content-end mt-1">
                        <div class="col-md-5">
                            <div class="form-group">
                                <label for="jenbar_id">Jenis Barang <span class="text-danger">*</span></label>
                                <select wire:model='jenbar_id'
                                    class="form-control form-select  @error('jenbar_id') is-invalid @enderror"
                                    id="jenbar_id">
                                    <option value="">Pilih Jenis Barang</option>
                                    @foreach ($JenisBarang as $jenbar)
                                    @if ($jenbar->id)
                                    <option value="{{ $jenbar->id }}" selected>{{ $jenbar->jenbar }} | {{
                                        $jenbar->k_jenbar }}</option>
                                    @else
                                    <option value="{{ $jenbar->id }}">{{ $jenbar->jenbar }} | {{
                                        $jenbar->k_jenbar }}</option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('jenbar_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="nambar_id">Nama Barang <span class="text-danger">*</span></label>
                                <select wire:model='nambar_id'
                                    class="form-control form-select  @error('nambar_id') is-invalid @enderror"
                                    id="nambar_id">
                                    <option value="">Pilih Nama Barang</option>
                                    @foreach ($NamaBarang as $nambar)
                                    @if ($nambar->id)
                                    <option value="{{ $nambar->id }}" selected>{{ $nambar->nambar }} | {{
                                        $nambar->k_nambar }}</option>
                                    @else
                                    <option value="{{ $nambar->id }}">{{ $nambar->nambar }} | {{ $nambar->k_nambar }}
                                    </option>
                                    @endif
                                    @endforeach
                                </select>
                                @error('nambar_id')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-1 d-flex align-items-end">
                            @if ($this->update == true && $this->create == false)
                            <div class="form-group">
                                <button wire:click.prevent='Update({{ $this->id_inven }})'
                                    class="btn btn-primary ">Update</button>
                            </div>
                            @else
                            <div class="form-group">
                                <button wire:click.prevent='Simpan' class="btn btn-primary ">Simpan</button>
                            </div>
                            @endif
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
                        <th>Jenis Barang</th>
                        <th>Nama Barang</th>
                        <th>Stok Barang</th>
                        <th>Tanggal Register</th>
                        <th>Petugas</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $Inventaris->firstItem()  ?>
                    @foreach ($Inventaris as $inventaris)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $inventaris->k_inven }}</td>
                        <td>{{ $inventaris->Jenbar->jenbar }}</td>
                        <td>{{ $inventaris->Nambar->nambar }}</td>
                        <td class="text-center">{{ $inventaris->jumlah }}</td>
                        <td class="text-center">{{ date('d M Y', strtotime( $inventaris->created_at)) }}</td>
                        <td>{{ $inventaris->User->nama }}</td>
                        <td><a wire:click="Edit({{ $inventaris->id }}) " type="button" data-toggle="modal"
                                data-target="#create"><i class="fas fa-pen text-primary"></i></a>
                            |
                            <a wire:click="DeleteData({{ $inventaris->id }}) " type="button"><i
                                    class=" fas fa-trash text-danger" data-toggle="modal" data-target="#delete"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @if ($Inventaris->firstItem() == 0)
                    <tr>
                        <td colspan="8" class="text-center">Data Kosong</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-5 d-flex align-items-center ">
                    <p>
                        Showing {{ $Inventaris->firstItem() }} to {{ $Inventaris->lastItem() }} of {{
                        $Inventaris->total() }}
                        entries
                    </p>
                </div>
                <div class="col-md-7">
                    <p>
                        {{ $Inventaris->links() }}
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
                    <p class="col-form-label">Yakin Hapus Kode Inventasi: {{ $this->k_inven }}
                </div>
                <div class="modal-footer">
                    <button wire:click='Close' type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"
                        wire:click.prevent="Delete({{ $this->id_inven }})">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>