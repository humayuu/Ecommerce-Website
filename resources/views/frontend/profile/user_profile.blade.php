@extends('frontend.main_master')
@section('content')
    <div class="body-content">
        <div class="container">
            <div class="row">
                <div class="col-md-2"><br><br>
                    <img class="card-img-top" style="border-radius: 50%"
                        src="{{ !empty($user->profile_photo_path) ? url('upload/user_images/' . $user->profile_photo_path) : url('upload/no_image.jpg') }}"
                        width="100%" height="100%">
                    <br><br>

                    <ul class="list-group list-group-flush">
                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('dashboard') }}">Home</a>
                        <a class="btn btn-primary btn-sm btn-block" href="{{ route('user.profile') }}">Profile Update</a>
                        <a class="btn btn-primary btn-sm btn-block" href="">Change Password</a>
                        <a class="btn btn-danger btn-sm btn-block" href="{{ route('user.logout') }}">Logout</a>
                    </ul>
                </div>
                <div class="col-md-2">

                </div>
                <div class="col-md-6">
                    <div class="card">
                        <h3 class="text-center"><span
                                class="text-danger">Hi......</span><strong>{{ Auth::user()->name }}</strong>Update Your
                            Profile</h3>

                        <div class="card-body">
                            <form method="POST" action="{{ route('user.profile.store') }}" enctype="multipart/form-data">
                                @csrf
                                 <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Name</label>
                                    <input type="text" class="form-control" name="name" value="{{ $user->name }}">
                                </div>

                                 <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Email</label>
                                    <input type="email" class="form-control" name="email" value="{{ $user->email }}">
                                </div>

                                 <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">Phone</label>
                                    <input type="text" class="form-control" name="phone" value="{{ $user->phone }}">
                                </div>

                                 <div class="form-group">
                                    <label class="info-title" for="exampleInputEmail2">User Image</label>
                                    <input type="file" class="form-control" name="profile_photo_path">
                                </div>

                                 <div class="form-group">
                                    <button type="submit" class="btn btn-danger">Update</button>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>
@endsection
