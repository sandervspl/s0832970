<?php $user = Auth::user() ?>
@extends('layouts.master')
@section('title', 'Edit')
@section('content')
    <section class="main-article">
        <div class="profile-header">
            <h1>Profile Settings</h1>

            @include('partials/edit_account_menu')

            {!!
                Form::open([
                    'action' => 'ProfileController@update',
                    'files'  => true,
                    'class'  => 'form-horizontal'
                ])
            !!}

            <div class="form-group">
                {!! Form::label('image', 'Profile Picture', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-3">
                    {!! Form::file(
                            'image',
                            null,
                            [
                                'class'    => 'form-control input-sm',
                                'required' => 'required'
                            ]
                        )
                     !!}
                </div>
            </div>


            <div class="form-group">
                {!! Form::label('bio', 'Bio', ['class' => 'col-sm-3 control-label']) !!}
                <div class="col-sm-9">
                    {!! Form::textarea('bio', $user->profile->bio, ['class' => 'form-control']) !!}
                </div>
            </div>


            <div class="form-group">
                <div class="col-sm-offset-3 col-sm-9">
                    {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
                </div>
            </div>

            {!! Form::close() !!}
        </div>
    </section>
@endsection