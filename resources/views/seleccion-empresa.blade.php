@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-6 offset-md-3">
                <h2 class="text-center text-dark mt-5">Seleccione una Empresa</h2>
                <div class="card my-3">
                    <form method="POST" action="" class="card-body cardbody-color p-5">
                        @csrf
                        <div class="row m-3">
                            <div class="mb-2 col">
                                <label class="h5">Empresa:</label>
                            </div>
                            <div class="text-center col">
                                <select class="form-select" id="nom-empresa">
                                    @foreach ($data->empresas ?? [] as $empresa)
                                        <option value="{{ $empresa->id_empresa }}">{{ $empresa->nombre }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col">
                                <button type="button" class="btn btn-primary form-control"
                                    onclick="redireccionar()">Ingresar</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-success form-control" data-bs-toggle="modal"
                                    onclick="seleccionarCrear()" data-bs-target="#modalempresa">Nuevaaa Empresa</button>
                                    <span class="btn-outline-success" data-feather="plus-square"></span>
                            </div>
                        </div>
                        <div class="row m-3">
                            <div class="col">
                                <button type="button" class="btn btn-primary form-control" data-bs-toggle="modal"
                                    data-bs-target="#modalempresa" onclick="seleccionarEditar()">Editar</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-outline-danger form-control">Eliminar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('registro-empresa')
@endsection
@section('scripts')
    <style>
        .btn-color {
            background-color: #0e1c36;
            color: #fff;
        }

        .cardbody-color {
            background-color: #ebf2fa;
        }

        a {
            text-decoration: none;
        }

    </style>
    @include('validacion-empresa');
    <script>
        let redireccionar = () => {
            let sel = document.getElementById("nom-empresa");
            let text = sel.options[sel.selectedIndex].text;
            window.location.replace("https://queeserp.tk/lista/" + text + "/");
        };
    </script>
@endsection
