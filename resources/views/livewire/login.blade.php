<div>
    <section class="vh-100">
        <div class="container-fluid h-custom">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col-md-9 col-lg-6 col-xl-5">
                    <img src="{{ asset('img/inventory.jpg') }}" class="img-fluid" alt="Sample image">
                </div>
                <div class="col-md-8 col-lg-6 col-xl-4 offset-xl-1">
                    <div class="card shadow p-3 mb-5 bg-white rounded border-success">
                        <div class="card-body">
                            @if (session()->has('error'))
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                {{ session('error') }}
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            @endif
                            <form>
                                <!-- Email input -->
                                <div class="form-outline mb-4">
                                    <label class="form-label">Email</label>
                                    <input wire:model='email' type="email"
                                        class="form-control form-control-lg @error('email') is-invalid @enderror"
                                        placeholder="Masukan Email" />
                                    @error('email')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <!-- Password input -->
                                <div class="form-outline mb-3">
                                    <label class="form-label">Password</label>
                                    <input wire:model='password' type="password"
                                        class="form-control form-control-lg @error('password') is-invalid @enderror"
                                        placeholder="Masukan password" />
                                    @error('password')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                    @enderror
                                </div>

                                <div class="text-center text-lg-start mt-4 pt-2">
                                    <button wire:click.prevent='Login' type="button" class="btn btn-primary btn-lg"
                                        style="padding-left: 2.5rem; padding-right: 2.5rem;">Login</button>
                                </div>

                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </section>
</div>