@extends('layouts.profile')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        phone number verification
                    </div>
                    <div class="card-body">
                        <form action="{{route('profile.verifyToken')}}" method="post">
                            @csrf
                            <div class="form-group col-form-label">
                                <label for="token">Token:</label>
                                <input type="text" name="token" class="form-control @error("token") is-invalid @enderror " placeholder="Enter the token sent on your phone">
                                @error('token')
                                    <span class="invalid-feedback">
                                        <strong>{{$message}}</strong>
                                    </span>
                                @enderror
                            </div>

                            <div class="form-group">
                                <button class="btn btn-primary">validate token </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>



@endsection
