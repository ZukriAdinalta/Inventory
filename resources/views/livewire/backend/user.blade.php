<div>
    <div class="card border-success">
        <h5 class="card-header">Pengguna</h5>
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
            <button type="button" class="btn btn-success border" data-toggle="modal" data-target="#create">
                <li class="fas fa-plus"></li>
            </button>
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
                        <th>Nama</th>
                        <th>Email</th>
                        <th>No. HP</th>
                        <th>Level</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $no = $User->firstItem()  ?>
                    @foreach ($User as $user)
                    <tr>
                        <td>{{ $no++ }}</td>
                        <td>{{ $user->nama }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->no_hp }}</td>
                        <td>{{ $user->level == 1 ? 'Manager' : 'Kepala Gudang'}}</td>
                        <td>
                            @if ($user->status == 0)
                            <a wire:click="GPass({{ $user->id }}) " type="button" data-toggle="modal"
                                data-target="#password"><i class="fas fa-key text-secondary"></i></a>
                            |
                            @else
                            <a wire:click="HPass({{ $user->id }}) " type="button" data-toggle="modal"
                                data-target="#password"><i class="fas fa-key text-warning"></i></a>
                            |
                            @endif
                            <a wire:click="Edit({{ $user->id }}) " type="button" data-toggle="modal"
                                data-target="#create"><i class="fas fa-pen text-primary"></i></a>
                            |
                            <a wire:click="Edit({{ $user->id }}) " type="button"><i class=" fas fa-trash text-danger"
                                    data-toggle="modal" data-target="#delete"></i></a>
                        </td>
                    </tr>
                    @endforeach
                    @if ($User->firstItem() == 0)
                    <tr>
                        <td colspan="6" class="text-center">Data Kosong</td>
                    </tr>
                    @endif
                </tbody>
            </table>
            <div class="row">
                <div class="col-md-5 d-flex align-items-center ">
                    <p>
                        Showing {{ $User->firstItem() }} to {{ $User->lastItem() }} of {{
                        $User->total() }}
                        entries
                    </p>
                </div>
                <div class="col-md-7">
                    <p>
                        {{ $User->links() }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah dan edit-->
    <div wire:ignore.self class="modal fade" id="create" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $update == false? 'Tambah User':'Edit User' }}
                    </h5>
                    <button wire:click='resetForm' type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input wire:model='nama' type="text"
                                class="form-control @error('nama') is-invalid @enderror">
                            @error('nama')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input wire:model='email' type="email"
                                class="form-control @error('email') is-invalid @enderror">
                            @error('email')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nomor Hp</label>
                            <input wire:model='no_hp' type="number"
                                class="form-control @error('no_hp') is-invalid @enderror">
                            @error('no_hp')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <textarea wire:model='alamat' class="form-control @error('alamat') is-invalid @enderror"
                                rows="2"></textarea>
                            @error('alamat')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @if ($update == false)
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password</label>
                            <input wire:model='password' type="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Konfirmasi Password</label>
                            <input wire:model='password_confirmation' type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        @endif
                        <div class="form-group">
                            <label for="exampleFormControlSelect1">Level</label>
                            <select wire:model='level' class="form-control">
                                @if ($this->update == false)
                                <option value="">Pilih Level User</option>
                                <option value="1">Manager</option>
                                <option value="2">Kepala Gudang</option>
                                @else
                                @if ($this->level == 2)
                                <option value="2">Kepala Gudang</option>
                                <option value="1">Manager</option>
                                @else
                                <option value="1">Manager</option>
                                <option value="2">Kepala Gudang</option>
                                @endif
                                @endif

                            </select>
                        </div>
                        @if ($update == true)
                        <div class="modal-footer">
                            {{-- <input wire:model='password' type="password" class="form-control "> --}}
                            <button wire:click='resetForm' type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button wire:click.prevent='Update()' class="btn btn-primary">Update</button>
                        </div>
                        @else
                        <div class="modal-footer">
                            <button wire:click='resetForm' type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button wire:click.prevent='Simpan' class="btn btn-primary">Simpan</button>
                        </div>
                        @endif
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Password-->
    <div wire:ignore.self class="modal fade" id="password" tabindex="-1" data-backdrop="static" data-keyboard="false">
        <div class="modal-dialog">
            <div class="modal-content text-dark border-primary {{ $this->hapus_pass == true ? ' bg-warning' : '' }}">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $this->hapus_pass == true ? 'Nonaktif
                        User':'Password Baru' }}
                    </h5>
                    <button wire:click='resetForm' type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @if ($this->hapus_pass == true && $this->ganti_pass == false)
                <div class="modal-body justify-content-center">
                    <input wire:model="id_user" type="hidden">
                    <p class="col-form-label">Yakin Nonaktifkan User: {{ $this->nama }}
                </div>
                <div class="modal-footer">
                    <button wire:click='resetForm' type="button" class="btn btn-secondary"
                        data-dismiss="modal">Tidak</button>
                    <button type="submit" class="btn btn-primary"
                        wire:click.prevent="Password({{ $this->id_user }})">Ya</button>
                </div>
                @elseif($this->ganti_pass == true )
                <div class="modal-body justify-content-center">
                    <input wire:model="id_user" type="hidden">
                    <p class="col-form-label">Nama: {{ $this->nama }}
                    <p class="col-form-label">Email: {{ $this->email }}
                    <p class="col-form-label">Password Baru: {{ $this->password }}
                </div>
                <div class="modal-footer">
                    <button wire:click='resetForm' type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                </div>
                @endif
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
                    <input wire:model="id_user" type="hidden">
                    <p class="col-form-label">Yakin Hapus Data: {{ $this->nama }}
                </div>
                <div class="modal-footer">
                    <button wire:click='resetForm' type="button" class="btn btn-secondary"
                        data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary"
                        wire:click.prevent="Delete({{ $this->id_user }})">Delete</button>
                </div>
            </div>
        </div>
    </div>
</div>