<!-- resources/views/transaction_purpose/create.blade.php -->
@extends('layouts.admin')
@section('title','Buat Tujuan Deposito')
@section('container')
    <h1>Create New Transaction Purpose</h1>
    <form method="POST" action="{{ route('tujuandepo.store') }}">
        @csrf

        <!-- noacc depo -->
        <div>
            <select name="noacc_depo">
                @foreach ($noaccList as $noacc)
                    <option value="{{ $noacc->noacc }}" @selected(old('noacc_depo') == $noacc->noacc)>
                        {{ $noacc->noacc }}-{{ $noacc->fnama }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="type_tran" :value="__('type_tran')" />
            <select name="type_tran" id="type_tran" required @selected(old('type_tran'))>
                <option value="Cash">Cash</option>
                <option value="Tabungan">Tabungan</option>
                <option value="Transfer">Transfer</option>
            </select>
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="norek_tujuan" :value="__('norek_tujuan')" />
            <x-text-input id="norek_tujuan" class="block mt-1 w-full" type="text" name="norek_tujuan" :value="old('norek_tujuan')" autocomplete="norek_tujuan" />
            <x-input-error :messages="$errors->get('norek_tujuan')" class="mt-2" />
        </div>

        <!-- Email Address -->
        <div class="mt-4">
            <x-input-label for="an_tujuan" :value="__('an_tujuan')" />
            <x-text-input id="an_tujuan" class="block mt-1 w-full" type="text" name="an_tujuan" :value="old('an_tujuan')" autocomplete="an_tujuan" />
            <x-input-error :messages="$errors->get('an_tujuan')" class="mt-2" />
        </div>

        <!-- Password -->
        <div class="mt-4">
            <x-input-label for="nama_bank" :value="__('nama_bank')" />
            <x-text-input id="nama_bank" class="block mt-1 w-full" type="text" name="nama_bank" :value="old('nama_bank')" autocomplete="nama_bank"/>
            <x-input-error :messages="$errors->get('nama_bank')" class="mt-2" />
        </div>

        <div class="flex items-center justify-end mt-4">
            <x-primary-button class="ms-4">
                {{ __('Submit') }}
            </x-primary-button>
        </div>
    </form>
@endsection
