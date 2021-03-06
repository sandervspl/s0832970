<?php $p = Config::get('constants.permissions') ?>
@extends('layouts.master')
@section('title', 'All Users')
@section('content')
<section class="main-article admin-page">
    <h1>Administration - All Users</h1>

    <div id="admin-menu">
        <ul>
            @include('partials/admin_menu')

            <li class="role-filter-list-item">
                <div class="filter-role-container">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
                            Filter Role
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenu1">
                            <li><a href="{{ action('AdminController@index') }}">All</a></li>
                            <li class="divider"></li>
                            <?php $roles = App\Role::all() ?>
                            @foreach($roles as $role)
                                <li>
                                    <a href="{{ action('AdminController@userRoles', ['role_id' => $role->id]) }}">{{ ucfirst(trans($role->name)) }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </li>
        </ul>
    </div>

    @include('partials/admin_search_users')

    <table>
        <tr>
            <th>User</th>
            <th>Banned</th>
            <th>Role</th>
            <th>Manage</th>
        </tr>
        @foreach($users as $user)
        <tr class="users-data">
            <td> {{ $user->name }} </td>

            <?php
                $class = ($user->banned) ? 'onoff ban is-transitioned' : 'onoff ban';

                if ($user->role >= 4)
                    $class .= ' hidden';
            ?>
            <td>
                <div class="{{ $class }}" data-userid="{{ $user->id }}"
                     data-isbanned="{{ $user->banned }}">
                    <div class="load-spinner onoff-button hidden"></div>
                    <div class="onoff-circle"></div>
                </div>
            </td>

            <?php $disabled = (Auth::User()->role < $p['change_role']) ? 'disabled' : ''; ?>
            <td>
                {!! Form::open([
                        'action' => 'UserController@updateRole'
                    ])
                !!}

                <label for="role" class="control-label"></label>
                <select name="role" id="{{ $user->id }}-role" class="form control input-sm admin-role-dropdown role-list"
                        data-userid="{{ $user->id }}" data-userrole="{{ $user->role }}" {{ $disabled }}>
                    @foreach(\App\Role::all() as $role)
                        @if($user->role == $role->id)
                            <option value="{{ $role->id }}" selected>{{ $role->name }}</option>
                        @else
                            <option value="{{ $role->id }}">{{ $role->name }}</option>
                        @endif
                    @endforeach
                </select>

                {!! Form::hidden('user_id', $user->id) !!}

                {!! Form::close() !!}
            </td>

            <td>
                <a href="{{ action('ProfileController@show', ['user_name' => $user->name]) }}">
                    Profile
                </a>

                <span> | </span>

                @if (Auth::User()->role >= $p['edit_profile'])
                <a href="{{ action('ProfileController@editProfile', ['user_name' => $user->name]) }}">
                    Edit
                </a>
                @else
                    Edit
                @endif

                <span> | </span>

                @if (Auth::User()->role >= $p['remove_user'])
                <a href="{{ action('AdminController@removeUser', ['user_id' => $user->id]) }}" class="remove-link">
                    Remove user
                </a>
                @else
                    Remove user
                @endif
            </td>
        </tr>
        <tr class="spacer"></tr>
        @endforeach
    </table>

    <div class="text-center">
        {{ $users->links() }}
    </div>

    <div class="popup success">
        <div class="inner">
            <div class="header"></div>
            <div class="text">
                <h1>Success</h1>
            </div>
        </div>
    </div>

    <div class="popup fail">
        <div class="inner">
            <div class="header"></div>
            <div class="text">
                <h1>Failed</h1>
            </div>
        </div>
    </div>
</section>
<script>
    var updateRoleUrl = '{{ route('updateRole') }}',
        banUrl = '{{ route('banUser') }}',
        token = '{{ csrf_token() }}';
</script>
@endsection