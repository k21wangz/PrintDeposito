<!-- resources/views/transaction_purpose/index.blade.php -->
@extends('layouts.admin')
@section('title','Tujuan Deposito')
@section('container')
    <h1>Transaction Purposes</h1>
    <a href="{{ route('tujuandepo.create') }}">Create New</a>

    <table>
        <thead>
        <tr>
            <th>ID</th>
            <th>Transaction ID</th>
            <th>Purpose Type</th>
            <th>Account Number</th>
            <th>Account Holder Name</th>
            <th>Bank Name</th>
            <th>Noacc Depo</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($transactionPurposes as $purpose)
            <tr>
                <td>{{ $purpose->id }}</td>
                <td>{{ $purpose->transaction_id }}</td>
                <td>{{ $purpose->purpose_type }}</td>
                <td>{{ $purpose->account_number }}</td>
                <td>{{ $purpose->account_holder_name }}</td>
                <td>{{ $purpose->bank_name }}</td>
                <td>{{ $purpose->noacc_depo }}</td>
                <td>
                    <a href="{{ route('tujuandepo.show', $purpose->id) }}">View</a>
                    <a href="{{ route('tujuandepo.edit', $purpose->id) }}">Edit</a>
                    <form action="{{ route('tujuandepo.destroy', $purpose->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection
