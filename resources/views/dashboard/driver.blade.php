@extends('layouts.app')

@section('content')

<div class="space-y-6">

<h1 class="text-3xl font-bold">

Dashboard Driver

</h1>

<p>

Selamat datang,

{{ auth()->user()->name }}

</p>

<div class="grid grid-cols-1 md:grid-cols-3 gap-6">

<div class="bg-white p-6 rounded-xl shadow">

TPS Hari Ini

<h2 class="text-3xl font-bold mt-2">

0

</h2>

</div>

<div class="bg-white p-6 rounded-xl shadow">

Pengangkutan

<h2 class="text-3xl font-bold mt-2">

0

</h2>

</div>

<div class="bg-white p-6 rounded-xl shadow">

Status

<h2 class="text-xl mt-2">

Siap Bertugas

</h2>

</div>

</div>

</div>

@endsection