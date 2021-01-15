@extends('layouts.master')
@section('title')
Starter Page
@endsection
@section('body')
<body>
@endsection
@section('content')
@component('common-components.breadcrumb')
    @slot('pagetitle') Utility @endslot
    @slot('title') Starter Page @endslot
@endcomponent
@endsection