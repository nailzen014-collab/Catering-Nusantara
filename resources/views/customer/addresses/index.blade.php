@extends('layouts.app')

@section('content')
<div class="container address-page" style="padding-top:42px;padding-bottom:64px;">

    <div class="d-flex justify-content-between align-items-center mb-4">
        <div>
            <h2>Alamat Saya</h2>
            <p class="text-muted">Simpan alamat yang bisa digunakan saat checkout.</p>
        </div>

        <a href="{{ route('addresses.create') }}" class="btn btn-primary lp-btn lp-btn-gold">
            + Tambah Alamat
        </a>
    </div>

    @forelse ($addresses as $address)
        <div class="card mb-3 address-card">
            <div class="card-body">
                <h5>{{ $address->label }}</h5>

                <strong>{{ $address->recipient_name }}</strong>
                <p class="mb-1">{{ $address->phone }}</p>
                <p class="mb-0">
                    {{ $address->address }}
                    @if($address->city)
                        , {{ $address->city->name }}
                    @endif
                </p>

                <div class="mt-3">
                    <a href="{{ route('addresses.edit', $address) }}"
                       class="btn btn-sm btn-warning">
                        Edit
                    </a>

                    <form action="{{ route('addresses.destroy', $address) }}"
                          method="POST"
                          class="d-inline">
                        @csrf
                        @method('DELETE')

                        <button class="btn btn-sm btn-danger"
                                onclick="return confirm('Hapus alamat ini?')">
                            Hapus
                        </button>
                    </form>
                </div>
            </div>
        </div>
    @empty
        <div class="alert alert-info surface" style="padding:24px;">
            Belum ada alamat. Silakan tambahkan alamat terlebih dahulu.
        </div>
    @endforelse

</div>
@endsection