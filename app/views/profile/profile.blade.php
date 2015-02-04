@extends('...layouts.master')

@section('content')
Hi
    {{ link_to('/logout', 'Logout', array('class' => 'btn btn-primary')); }}
@stop