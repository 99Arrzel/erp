@extends('layouts.app')
@include('header')
@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
        <div class="col-12">
            <label class="h4 mb-3">Plan de cuentas para {{ $usuario->empresas[0]->nombre }}
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalCuentas" title="Agregar"
                    id="botonAgregarCuenta" class="ms-3 btn btn-outline-success" onclick="agregarCuenta()"><i
                        class="bi bi-plus-square-fill"></i>
                </button>
            </label>
        </div>
        <div>
            <p>
                Buscar:
                <input id="buscarEnArbol" />
            </p>
        </div>
        <div class="col-12" id="arbol">
        </div>
    </main>
@endsection
@section('scripts')
    <script>
        console.log($('#arbol'));
        $('#arbol').jstree({
            'core': {
                'data': {
                    'url': '{{ route('listarCuentasApi') }}',
                    'type': 'POST',
                    'data': function() {
                        return {
                            '_token': '{{ csrf_token() }}',
                            'id_empresa': {{ $usuario->empresas[0]->id_empresa }},
                        };

                    },
                    "check_callback": true,
                },
            },
            types: {
                "default": {
                    "icon": "bi bi-diagram-3",
                }
            },
            "plugins": ["types", "search", "contextmenu"],
            "contextmenu": {
                "items": [{
                    "createItem": {
                        "label": "Crear",
                        "action": function(data) {
                            console.log(data, "Creando");
                        },
                        "title": "Crear un nuevo hijo",
                        _disabled: false,
                    }
                }]
            }
        });
        var to = false;
        $('#buscarEnArbol').keyup(function() {
            if (to) {
                clearTimeout(to);
            }
            to = setTimeout(function() {
                var v = $('#buscarEnArbol').val();
                $('#arbol').jstree(true).search(v);
            }, 250);
        });
    </script>
@endsection
