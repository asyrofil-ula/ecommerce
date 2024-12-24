@extends('layouts.templateUser')

@section('content')

<div class="container py-5">

    <div class="container-fluid d-flex justify-content-center align-items-center vh-100 py-5">
        <div class="col-lg-4 text-center">
            <div class="bg-light p-4">
                <h1 class="mb-4">Profile</h1>
                @foreach (DB::table('users')->where('id', Auth::user()->id)->get() as $user)
                    <div class="mt-3">
                        <label for="name" class="form-label">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" readonly>    
                    </div>
                    <div class="mt-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="{{ $user->email }}" readonly>    
                    </div>
                    <div class="mt-3">
                        <label for="phone" class="form-label">Phone</label>
                        <input type="text" class="form-control" id="phone" name="phone" value="{{ $user->phone }}" readonly>    
                    </div>
                    <div class="mt-3">
                        <label for="address" class="form-label">Address</label>
                        <input type="text" class="form-control" id="address" name="address" value="{{ $user->address }}" readonly>    
                    </div>
                    <p class="mt-4">Update your profile information</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit</a>
                @endforeach
    
                <!-- Logout -->
                <form method="POST" action="{{ route('logout') }}" class="mt-3">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>




@endsection