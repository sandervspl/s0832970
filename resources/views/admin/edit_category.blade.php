@extends('layouts.master')
@section('title', 'Administration - Edit Category')
@section('content')
    <section class="main-article admin-page">
        <h1>Administration - Edit Category</h1>
        <h4 class="alt-title">{{ $category->name }}</h4>

        <div class="row">
        {!! Form::open([
                'action' => 'CategoryController@editName',
                'class'  => 'form-horizontal'
            ])
        !!}

        {!! Form::hidden('category_id', $category->id) !!}

        <div class="form-group">
            {!! Form::label('name', 'Category*', ['class' => 'col-sm-2 control-label']) !!}
            <div class="col-sm-6">
                {!! Form::text('name', $category->name, ['class' => 'form-control', 'required' => 'required']) !!}
            </div>

            @if ($errors->has('name'))
            <span class="help-block col-sm-offset-2 col-sm-6 error-text">
                <strong>{{ $errors->first('name') }}</strong>
            </span>
            @endif
        </div>

        <div class="form-group">
            <div class="col-sm-offset-2 col-sm-6">
                {!! Form::submit('Save Changes', ['class' => 'btn btn-primary']) !!}
            </div>
        </div>
        {!! Form::close() !!}
        </div>
    </section>
@endsection