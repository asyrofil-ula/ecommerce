@extends('layouts.templateUser')

@section('content')

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4 text-center">
            <div class="align-items-center text-center p-3 py-5">
                <div class="card-body">
                    <h1>Profile</h1>
                    @foreach ($users = DB::table('users')->where('id', Auth::user()->id)->get() as $user)

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


                    <p>Update your profile information and image.</p>
                    <a href="{{ route('profile.edit') }}" class="btn btn-primary">Edit</a>
                </div>
                @endforeach

                <!-- logout -->
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="btn btn-danger">Logout</button>
                </form>
            </div>
        </div>
    </div>
</div>



@endsection