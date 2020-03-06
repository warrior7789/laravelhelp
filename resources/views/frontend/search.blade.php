@extends('frontend.layouts.app')

@section('title', app_name() . ' | ' . __('navs.general.home'))

@section('content')
   

   
            {{-- <homesearch-component></homesearch-component> --}}
            <router-view></router-view>
        

    
@endsection
