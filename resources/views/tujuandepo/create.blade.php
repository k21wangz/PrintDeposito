<!-- resources/views/transaction_purpose/create.blade.php -->
@extends('layouts.admin')
@section('title','Buat Tujuan Deposito')
@section('container')
    <h1>Create New Transaction Purpose</h1>

    <form action="{{ route('tujuandepo.store') }}" method="POST">
        @csrf
        <select name="noacc_depo" id="noacc_depo" required>
            @foreach($noaccList as $noacc)
                <option value="{{ $noacc->noacc }}">{{ $noacc->noacc }}-{{ $noacc->fnama }}</option>
            @endforeach
        </select>

        <label for="purpose_type">Purpose Type:</label>
        <select name="purpose_type" id="purpose_type" required>
            <option value="cash">Cash</option>
            <option value="tabungan">Tabungan</option>
            <option value="transfer">Transfer</option>
        </select>

        <label for="account_number">Account Number:</label>
        <input type="text" name="account_number" id="account_number">

        <label for="account_holder_name">Account Holder Name:</label>
        <input type="text" name="account_holder_name" id="account_holder_name">

        <label for="bank_name">Bank Name:</label>
        <input type="text" name="bank_name" id="bank_name">

        <button type="submit">Create</button>
    </form>
@endsection
