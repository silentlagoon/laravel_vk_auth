@extends('layouts.master')

@section('content')
    <div class="col-lg-3 col-lg-offset-5 top100 word-break">
        @if(isset($message))
            <p class="bg-danger">{{ $message }}</p>
        @endif
        {{ Form::open(array('url' => '/login', 'method' => 'post' )) }}
            <div class="form-group">
                {{ Form::label('email', 'Email address') }}
                {{ Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'example@gmail.com')) }}
            </div>
            <div class="form-froup">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter password')) }}
            </div>
            {{ Form::submit('Login', array('class' => 'btn btn-primary right clearfix col-lg-12 top10')) }}
        {{ Form::close() }}
        <div class="text-center">
            {{ link_to('/register', 'Not yet registered?'); }}
        </div>
        <div class="text-center">
            {{ link_to($vk, 'Login via ВКонтакте') }}
        </div>
    </div>
@stop