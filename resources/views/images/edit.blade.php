@extends('layouts.master')
@section('title', 'Upload')
@section('content')
    <section class="main-article">
        <h1>Edit Image</h1>

        <div class="upload-form row">
            {!! Form::open([
                    'action' => 'ImageController@update',
                    'files'  => true,
                    'class'  => 'form-horizontal'
                ])
            !!}

            <div class="edit-image col-md-3">
                <div class="form-group">
                    <img src="{{ '/uploads/'.$image->image_uri }}" alt="image" class="col-md-4 image-body-src">
                </div>
            </div>

            <div class="edit-image-info col-md-8">
                {!! Form::hidden('id', $image->id) !!}

                <div class="form-group">
                    {!! Form::label('category', 'Category*', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-2">
                        {!! Form::select(
                                'category',
                                [
                                    'comics' => 'Comics',
                                    'nature' => 'Nature',
                                    'music'  => 'Music'
                                ],
                                $image->category,
                                [
                                    'class'       => 'form control input-sm',
                                    'placeholder' => 'Pick a category...',
                                    'required'    => 'required'
                                ]
                            )
                        !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('title', 'Title*', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::text('title', $image->title, ['class' => 'form-control', 'required' => 'required']) !!}
                    </div>
                </div>


                <div class="form-group">
                    {!! Form::label('description', 'Description', ['class' => 'col-sm-2 control-label']) !!}
                    <div class="col-sm-10">
                        {!! Form::textarea('description', $image->description, ['class' => 'form-control']) !!}
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-2 col-sm-10">
                        {!! Form::submit('Edit Image', ['class' => 'btn btn-primary']) !!}
                    </div>
                </div>
            </div>
            {!! Form::close() !!}
        </div>
    </section>
@endsection