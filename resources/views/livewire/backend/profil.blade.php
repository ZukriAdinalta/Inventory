<div>
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
    <div class="row">
        <div class="col-md-4">
            <div class="card w-80">
                <img src="{{ asset('img/profil.jpg') }}" class="card-img-top" alt="..." height="200px">
                <div class="card-body">
                    <ul class="list-group list-group-flush pb-0">
                        <li class="list-group-item">{{ $this->nama }}</li>
                        <li class="list-group-item">{{ $this->email }}</li>
                        <li class="list-group-item">{{ $this->level == 1 ? 'Manager' : 'Kepala Gudang' }}</li>
                        <li class="list-group-item pb-0"></li>
                    </ul>
                    <div class="card-body text-center mt-0">
                        <button wire:click='Edit' class="card-link btn btn-primary"><i class="fas fa-pen"></i></button>
                        <button wire:click='Ganpas' class="card-link btn btn-warning"><i
                                class="fas fa-key"></i></button>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-md-8">
            @if ($this->update == true)
            <div class="card">
                <h5 class="card-header">Ganti Profil</h5>
                <div class="card-body">
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
                                class="form-control @error('email') is-invalid @enderror" disabled>
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
                        <div class="modal-footer">
                            <button wire:click='Close' type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button wire:click.prevent='Update()' class="btn btn-primary">Update</button>
                        </div>
                    </form>
                </div>
            </div>
            @elseif($this->ganti_pass == true)
            <div class="card">
                <h5 class="card-header">Ganti Password</h5>
                <div class="card-body">
                    <form>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password Lama</label>
                            <input wire:model='old_password' type="password"
                                class="form-control @error('old_password') is-invalid @enderror">
                            @error('old_password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Password Baru</label>
                            <input wire:model='password' type="password"
                                class="form-control @error('password') is-invalid @enderror">
                            @error('password')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Konfirmasi Password Baru</label>
                            <input wire:model='password_confirmation' type="password"
                                class="form-control @error('password_confirmation') is-invalid @enderror">
                            @error('password_confirmation')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                            @enderror
                        </div>
                        <div class="modal-footer">
                            <button wire:click='Close' type="button" class="btn btn-secondary"
                                data-dismiss="modal">Close</button>
                            <button wire:click.prevent='Update()' class="btn btn-primary">Ganti Password</button>
                        </div>
                    </form>
                </div>
            </div>
            @endif

        </div>

    </div>
</div>