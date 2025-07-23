@extends('layouts.app')
@section('content')
<div class="container user-listing-sec">
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
    <div class="table-responsive details-sec">
        <div class="col-lg-12 col-md-12 col-sm-12 mb-3">
            <div class="row d-flex align-items-center">
                <div class="create-sec col-lg-8 col-md-8 col-sm-12 mt-3 page-sub-title">
                    <h6>View Users</h6>
                </div>
                <div class="create-sec col-lg-4 col-md-4 col-sm-12 mt-3 text-end">
                    <a href="{{ route('users.create') }}"><button type="button" class="btn btn-light">Create <i class="fa-solid fa-chevron-right"></i></button></a>
                </div>
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
        <table class="table" id="listing_table">
            <thead>
                <tr class="table-active">
                    <th scope="col">Name</th>
                    <th scope="col">Email</th>
                    <th scope="col">User Type</th>
                    <th scope="col">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                    <tr>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->user_type }}</td>
                        <td>
                            <a href="{{ route('users.show', $user) }}"><i class="fa-solid fa-magnifying-glass action-icon"></i></a>
                            <a href="{{ route('users.edit', $user) }}"><i class="fa-solid fa-pen-to-square action-icon"></i></a>
                            <button class="delete-btn" data-resource-id="{{$user->id }}"><i class="fa-solid fa-trash-can action-icon"></i></button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
  </div>
</div>
<script>
    jQuery(document).ready(function() {
        var delete_user = "{{ route('users.destroy', ':id') }}";
        jQuery('.delete-btn').on('click', function(){
            jQuery('#DeleteModalLabel').html('Delete User');
            var resource_id = jQuery(this).attr('data-resource-id');
            var actionUrl = delete_user.replace(':id', resource_id);
            jQuery('#DeleteModal form').attr('action', actionUrl);
            jQuery('#DeleteModal').modal('show');
        });
    });
</script>

@endsection

