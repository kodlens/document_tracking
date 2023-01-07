@extends('layouts.app')

@section('content')
    <stock-in-create
        prop-id="{{ $id }}"
        prop-data='@json($data)'></stock-in-create>
@endsection
