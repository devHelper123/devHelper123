@extends('layouts.app')
@section('content')
<div class="container user-view-sec">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 page-title">
      <h4>Users</h4>
    </div>
    <div class="col-lg-12 col-md-12 col-sm-12 page-breadcrumbs">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ url('/') }}">
                    <i class="fa-solid fa-house"></i>
                </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">
                <a href="{{ url('users') }}">
                    Users
                </a>
            </li>
        </ol>
    </div>
    <div class="details-sec">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="row d-flex align-items-center">
                <div class="create-sec col-lg-8 col-md-8 col-sm-12 mt-3 page-sub-title">
                    <h6>View User</h6>
                </div>
                <div class="create-sec col-lg-4 col-md-4 col-sm-12 mt-3 text-end">
                    <a href="{{ url('users') }}"><i class="fa-solid fa-chevron-left action-icon"></i></a>
                    <a href="{{ route('users.edit', $user) }}"><i class="fa-solid fa-pen-to-square action-icon"></i></a>
                </div>
            </div>
        </div>
        <hr>
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3 p-4 user-view-det">
            <div class="col-lg-6 col-md-6 col-sm-12 user-view-data"> 
                <div class="user-data">
                    <div class="left-contents">
                        <strong>Name:</strong>
                    </div>
                    <div class="right-contents">
                        {{ $user->name }}
                    </div>
                </div>
                <div class="user-data">
                    <div class="left-contents">
                        <strong>User Type:</strong>
                    </div>
                    <div class="right-contents">
                        {{ $user->user_type }}
                    </div>
                </div>
                <div class="user-data">
                    <div class="left-contents">
                        <strong>Email:</strong>
                    </div>
                    <div class="right-contents">
                        {{ $user->email }}
                    </div>
                </div>
                <div class="user-data">
                    <div class="left-contents">
                       <strong>Phone Number:</strong>
                    </div>
                    <div class="right-contents">
                        {{ $user->phone }}
                    </div>
                </div>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-12 user-img-sec text-center user-view-img">
                @if($user->profile_image_url != '')
                    <img src="{{ $user->profile_image_url }}" class="user-img">
                @endif
            </div>
        </div>
    </div>
  </div>
</div>
@endsection

