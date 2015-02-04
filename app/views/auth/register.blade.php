@extends('layouts.master')

@section('content')
    <div class="col-lg-3 col-lg-offset-5 top100 word-break">
        @if(isset($response))
            @foreach($response as $message)
                <p class="bg-danger">{{ $message }}</p>
            @endforeach
        @endif
        {{ Form::open(array('url' => '/register', 'method' => 'post' )) }}
            <div class="form-group">
                {{ Form::label('email', 'Email address') }}
                {{ Form::text('email', '', array('class' => 'form-control', 'placeholder' => 'example@gmail.com')) }}
            </div>
            <div class="form-froup">
                {{ Form::label('password', 'Password') }}
                {{ Form::password('password', array('class' => 'form-control', 'placeholder' => 'Enter password')) }}
            </div>
            <div class="form-group">
                {{ Form::label('password_confirmation', 'Confirm password') }}
                {{ Form::password('password_confirmation', array('class' => 'form-control', 'placeholder' => 'Confirm password')) }}
            </div>
            {{ Form::submit('Register', array('class' => 'btn btn-primary right clearfix col-lg-12 top10')) }}
        {{ Form::close() }}
        <div class="text-center">
            {{ link_to('/login', 'To login page'); }}
        </div>
    </div>
@stop