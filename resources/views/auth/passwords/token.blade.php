@extends('layouts.app')

@section('content')

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        two factor authentication
                    </div>
                    <div class="card-body">
                        <form action="{{route("login.verifyTokenPhone")}}" method="post">
                            @csrf
                            <div class="form-group col-form-label">
                                <label for="token">Token:</label>
                                <input type="text" name="token" class="form-control @error("token") is-invalid @enderror " placeholder="Enter the token send on your phone">
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
