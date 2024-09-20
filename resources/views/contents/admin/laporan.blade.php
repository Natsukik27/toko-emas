@extends('layouts.app')

@section('content')
<div class="container mt-5">
    <h2>Laporan Keuangan</h2>

    <form action="{{ route('admin.laporan.generate') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="start_date" class="form-label">Tanggal Mulai</label>
            <input type="date" id="start_date" name="start_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">Tanggal Akhir</label>
            <input type="date" id="end_date" name="end_date" class="form-control" required>
        </div>
        <div class="mb-3">
            <label for="period" class="form-label">Periode</label>
            <select id="period" name="period" class="form-select" required>
                <option value="daily">Harian</option>
                <option value="monthly">Bulanan</option>
                <option value="yearly">Tahunan</option>
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Report</button>
    </form>

    @if(isset($reportData))
        <div class="mt-4">
            <h3>Hasil Laporan</h3>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Periode</th>
                        <th>Total Berat (g)</th>
                        <th>Total Pendapatan</th>
                        <th>Laba</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($reportData as $data)
                        <tr>
                            <td>{{ $data['period'] }}</td>
                            <td>{{ number_format($data['total_weight'], 2) }}</td>
                            <td>Rp{{ number_format($data['total_revenue'], 0, ',', '.') }}</td>
                            <td>Rp{{ number_format($data['profit'], 0, ',', '.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    @endif
</div>
@endsection


@section('styles')
<style>
    .card-rounded {
        border-radius: 0.5rem;
    }
    .table th, .table td {
        vertical-align: middle;
    }
</style>
@endsection
