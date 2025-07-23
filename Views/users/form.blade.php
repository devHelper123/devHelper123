@extends('layouts.app')
@section('content')
<div class="container user-listing-sec">
  <div class="row">
    <div class="col-lg-12 col-md-12 col-sm-12 page-title">
      <h4>Users</h4>
    </div>
    @if(auth()->user()->user_type === \App\Enums\UserType::ADMIN)
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
    @endif
    <div class="details-sec">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="row d-flex align-items-center">
                <div class="create-sec col-lg-8 col-md-8 col-sm-12 mt-3 page-sub-title">
                    <h6>{{ isset($user) ? 'Update' : 'Create' }} User</h6>
                </div>
                @if(isset($user) && $user->profile_image_url != '')
                    <div class="create-sec col-lg-4 col-md-4 col-sm-12 mt-3 text-end position-relative d-inline-block profile-img-sec">
                        <img src="{{ $user->profile_image_url }}" class="profile-img" width="70" height="70" alt="profile-img">
                        <i class="fa-solid fa-trash-can position-absolute bottom-0 end-0 m-1 text-danger bg-white rounded-circle p-1 delete-img"></i>
                    </div>
                @endif
            </div>
        </div>
         @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif
        <form class="row g-3 mb-3" method="POST" action="{{ isset($user) ? route('users.update', $user->id) : route('users.store') }}" enctype="multipart/form-data" autocomplete="off">
            @csrf
            @if(isset($user))
                @method('PATCH')
            @endif
            <input type="text" style="display:none" aria-hidden="true" autocomplete="username">
            <input type="password" style="display:none" aria-hidden="true" autocomplete="new-password">
            <input type="hidden" name="img_updated" id="img-updated" value="{{ (isset($user) && $user->profile_image_url != '') ? '1' : '0' }}">
            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="name" class="form-label">Name <span class="required-field"><i class="fa-solid fa-star-of-life"></i></span></label>
                <input type="text" class="form-control @if ($errors->has('name')) is-invalid @endif" name="name" id="name" value="{{ old('name', $user->name ?? '') }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="email" class="form-label">Email <span class="required-field"><i class="fa-solid fa-star-of-life"></i></span></label>
                <input type="text" class="form-control @if ($errors->has('email')) is-invalid @endif" name="email" id="email" value="{{ old('email', $user->email ?? '') }}">
                @error('email')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="phone" class="form-label">Phone Number <span class="required-field"><i class="fa-solid fa-star-of-life"></i></span></label>
                <input type="text" class="form-control @if ($errors->has('phone')) is-invalid @endif" name="phone" id="phone" value="{{ old('phone', $user->phone ?? '') }}">
                @error('phone')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="password" class="form-label">Password <span class="required-field"><i class="fa-solid fa-star-of-life"></i></span></label>
                <input type="password" class="form-control @if ($errors->has('password')) is-invalid @endif" name="password" id="password" value="">
                @error('password')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="password_confirmation" class="form-label">Confirm Password <span class="required-field"><i class="fa-solid fa-star-of-life"></i></span></label>
                <input type="password_confirmation" class="form-control @if ($errors->has('password_confirmation')) is-invalid @endif" name="password_confirmation" id="password_confirmation" value="">
            </div>
            <div class="col-lg-4 col-md-4 col-sm-12">
                <label for="image" class="form-label">Profile Image</label>
                <input type="file" class="form-control @if ($errors->has('image')) is-invalid @endif" name="image" id="image" value="{{ old('image', $user->image ?? '') }}">
                @error('image')
                <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>
            @if(auth()->user()->user_type === \App\Enums\UserType::ADMIN)
                <div class="col-lg-4 col-md-4 col-sm-12">
                    <label for="user_type" class="form-label">User Type <span class="required-field"><i class="fa-solid fa-star-of-life"></i></span></label>
                    <select class="form-control @if ($errors->has('user_type')) is-invalid @endif" name="user_type" id="user_type">
                        @php
                            $user_type = old('user_type', $user->user_type ?? '');
                            $selectedValue = is_object($user_type) ? $user_type->value : $user_type;
                        @endphp
                        <option value="">Select a user type</option>
                        @foreach($user_types as $type)
                            <option value="{{ $type->value }}" {{ ($selectedValue === $type->value) ? 'selected' : '' }}>
                                {{ ucfirst($type->value) }}
                            </option>
                        @endforeach
                    </select>
                    @error('user_type')
                    <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            @endif
            <div class="col-lg-12 col-md-12 col-sm-12 text-end">
                <a href="{{ (auth()->user()->user_type === \App\Enums\UserType::ADMIN) ? url('users') : url('/') }}" class="btn btn-light">Cancel</a>
                <button type="submit" class="btn btn-secondary">{{ isset($user) ? 'Update' : 'Submit' }}</button>
            </div>
        </form>
    </div>
  </div>
</div>
@endsection

