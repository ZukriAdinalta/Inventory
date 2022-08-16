<div>
    <div class="row">
        <div class="col-md-7">
            <div class="card border-success">
                <h5 class="card-header">Nama Barang</h5>
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
                    <div class="row mb-2 justify-content-end mt-1">
                        <div class="col-md-6">
                            <select wire:model='perpage' class="form-control w-auto">
                                <option value="5" selected>5</option>
                                <option value="10">10</option>
                                <option value="20">20</option>
                                <option value="50">50</option>
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
                                <th>Kode Barang</th>
                                <th>Nama Barang</th>
                                <th>Inventaris</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $no = $namaBarang->firstItem()  ?>
                            @foreach ($namaBarang as $nambar)
                            <tr>
                                <td>{{ $no++ }}</td>
                                <td>{{ $nambar->k_nambar}}</td>
                                <td>{{ $nambar->nambar}}</td>
                                <td>{{ $nambar->Inven->count() >= 1 ? 'Digunakan' : 'Belum Digunakan' }}</td>
                                <td><a wire:click="Edit({{ $nambar->id }})" type="button" data-toggle="modal"
                                        data-target="#create"><i class="fas fa-pen text-primary"></i></a>
                                    |
                                    <a wire:click="Edit({{ $nambar->id }})" type="button"><i
                                            class="fas fa-trash text-danger" data-toggle="modal"
                                            data-target="#delete"></i></a>
                                </td>
                            </tr>
                            @endforeach
                            @if ($namaBarang->firstItem() == 0)
                            <tr>
                                <td colspan="5" class="text-center">Data Kosong</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                    <div class="row">
                        <div class="col-md-5 d-flex align-items-center ">
                            <p>
                                Showing {{ $namaBarang->firstItem() }} to {{ $namaBarang->lastItem() }} of {{
                                $namaBarang->total() }}
                                entries
                            </p>
                        </div>
                        <div class="col-md-7">
                            <p>
                                {{ $namaBarang->links() }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="card border-success">
                <h5 class="card-header"> {{ $update == false ? 'Tambah' :'Edit' }} Nama Barang</h5>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Kode Barang</label>
                            <input wire:model='k_nambar' type="text"
                                class="form-control @error('k_nambar')is-invalid @enderror ">
                            @error('k_nambar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama Barang</label>
                            <input wire:model='nambar' type="text"
                                class="form-control @error('nambar')is-invalid @enderror ">
                            @error('nambar')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button wire:click='resetForm' type="button" class="btn btn-secondary">Reset</button>
                            @if ($update == true)
                            <button type="submit" class="btn btn-primary"
                                wire:click.prevent="Update({{ $this->id_nambar }})">Update</button>
                            @else
                            <button type="submit" class="btn btn-primary" wire:click.prevent="Simpan">Simpan</button>
                            @endif
                        </div>
                    </form>
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
                    <button wire:click='resetForm' type="button" class="close" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body justify-content-center">
                    <p class="col-form-label">Yakin Hapus Data: {{ $this->nambar }}
                </div>
                <div class="modal-footer">
                    <button wire:click='resetForm' type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"
                        wire:click.prevent="Delete({{ $this->id_nambar }})">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>