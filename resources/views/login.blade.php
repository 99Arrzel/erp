@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">Login ERP</h2>
                <div class="card my-3">
                    <form method="POST" action="https://queeserp.tk/login" class="card-body cardbody-color p-5">
                        @csrf
                        <div class="text-center">
                            <img src="https://c.tenor.com/-peQ41c9SE8AAAAj/greedy-radiant-soul.gif"
                                class="img-fluid profile-image-pic img-thumbnail rounded-circle mb-4" width="200px"
                                alt="profile">
                        </div>
                        <div class="mb-2">
                            <input type="text" class="form-control" name="usuario" aria-describedby="emailHelp"
                                placeholder="Usuario">
                        </div>
                        <div class="mb-2">
                            <input type="password" class="form-control" name="pass" placeholder="Contraseña">
                        </div>
                        <div class="text-center"><button type="submit"
                                class="btn btn-color px-5 mb-2 w-100">Login</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('scripts')
    <!--Esto antes estaba en layouts/app.blade.php dentro del head-->
    <style>
        .btn-color {
            background-color: #0e1c36;
            color: #fff;
        }
        .profile-image-pic {
            height: 200px;
            width: 200px;
            object-fit: cover;
        }
        .cardbody-color {
            background-color: #ebf2fa;
        }
        a {
            text-decoration: none;
        }
    </style>
@endsection
