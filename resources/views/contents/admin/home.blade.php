@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card bg-primary text-white card-rounded">
            <div class="card-body text-center pt-4">
                <h4 class="card-title">
                    <b><i class="fas fa-check me-1"></i></b> 
                    Selamat Datang Admin, <b>{{ auth()->user()->name }}</b>
                </h4>
                <a href="{{ route('home.index') }}" target="_blank" class="btn btn-success btn-lg mt-2">
                    <i class="fas fa-rocket me-2"></i> Lihat Website
                </a>
            </div>
        </div>

        <!-- New card for showing gold price -->
        <div class="card bg-warning text-dark card-rounded mt-4">
            <div class="card-body text-center pt-4">
                <h4 class="card-title">
                    <b><i class="fas fa-gold me-1"></i></b> 
                    Harga Emas Terbaru
                </h4>
                @if (isset($goldPrice))
                    <p class="mt-3">Harga emas per gram: <b>{{ number_format($goldPrice->price, 2, ',', '.') }}</b></p>
                    <p>Terakhir diperbarui: <b>{{ $goldPrice->updated_at->format('d M Y, H:i') }}</b></p>
                @else
                    <p class="mt-3">Data harga emas belum tersedia.</p>
                @endif
            </div>
        </div>
    </div>
    
@endsection

@section('styles')
    <style>
        .card-rounded {
            border-radius: 0.5rem;
        }
        .card-title i {
            font-size: 1.5rem;
        }
    </style>
@endsection
