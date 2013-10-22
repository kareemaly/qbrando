@extends('layouts.main')

@section('content')

    @include('partials.modal')

    <div class="sidebar">

        @include('sidebar.specials')

        @include('sidebar.categories')

        @include('sidebar.colors')

    </div>


    @include('partials.offers')

    <div class="body">

        @include('partials.search_form')

        @include('partials.products', compact('products', 'productsTitle'))

    </div>
@stop