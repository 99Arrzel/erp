@extends('layouts.app')
@include('header')
@section('content')
    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 mt-3">
        <div id="gestionesDiv">
            <label class="h4 mb-3">Administración Gestión</label>
            <p class="h6">
                Agregar Gestión
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalgestion" title="Agregar"
                    id="botonAgregarGestion" class="ms-3 btn btn-outline-success" onclick="agregarGestion()"><i
                        class="bi bi-plus-square-fill"></i>
                </button>
            </p>
            <table class="table table-striped" id="gestiones" style="width:100%"></table>
        </div>
        <div id="periodosDiv" style="display:none">
            <label class="h4 mb-3">Administración Periodo</label>
            <p class="h6">
                Agregar Periodo
                <button type="button" data-bs-toggle="modal" data-bs-target="#modalperiodo" title="Agregar"
                    id="botonAgregarPeriodo" class="ms-3 btn btn-outline-success" onclick="agregarPeriodo()"><i
                        class="bi bi-plus-square-fill"></i>
                </button>
                <button type="button" title="Volver atrás" class="ms-3 btn btn-outline-success"
                    onclick="retrodecerAGestion()"><i class="bi bi-backspace"></i>
                </button>
            </p>
            <table class="table table-striped" id="periodos" style="width:100%"></table>
        </div>
    </main>
    @include('registro-gestion')
    @include('registro-periodo')
@endsection
@section('scripts')
    <script>
        let retrodecerAGestion = () => {
            $('#gestionesDiv').show();
            $('#periodosDiv').hide();
        };
        let reload = () => {
            $('#gestiones').DataTable().ajax.reload();
        }
        let cerrarGestion = (id) => {
            $.ajax({
                url: '{{ route('cerrarGestion') }}',
                type: 'POST',
                data: {
                    id_gestion: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        reload();
                    }
                }
            });
        }
        let abrirGestion = (id) => {
            $.ajax({
                url: '{{ route('abrirGestion') }}',
                type: 'POST',
                data: {
                    id_gestion: id,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    if (data.success) {
                        reload();
                    }
                },
                error: function(data) {
                    Notify.failure(data.responseJSON.message);
                }
            });
        };

        let editarModal = (id, nombre, fecha_inicio, fecha_fin) => {
            /* Es para editar, cambiamos los datos del modal de crear. */
            $('#titleModalGestion').html('Editar Gestión');
            $('#btnGestion').html('Editar');
            $('#btnGestion').removeClass('btn-primary').addClass('btn-warning');
            $('#nombre').val(nombre);
            $('#fecha_inicio').val(dayjs(fecha_inicio).format('YYYY-MM-DD'));
            $('#fecha_fin').val(dayjs(fecha_fin).format('YYYY-MM-DD'));
            $('#id_gestion').val(id);
        };
        $(document).ready(() => {
            if (window.location.pathname == "/lista/{{ $usuario->empresas[0]->nombre }}/gestiones") {
                $('#gestiones_enlace').css("text-decoration", "underline");
            }
            $('#gestiones').DataTable({
                language: {
                    "url": '{{ asset('datatables/spanish.json') }}'
                },
                processing: true,
                serverSide: true,
                ajax: {
                    url: '{{ route('gestionData') }}',
                    data: {
                        empresa: '{{ $usuario->empresas[0]->nombre }}'
                    }
                },
                columns: [{
                        title: 'Nombre',
                        data: 'nombre',
                    },
                    {
                        title: 'Fecha de inico',
                        data: 'fecha_inicio',

                        render: (data) => {
                            return dayjs(data).format('DD/MM/YYYY');
                        }
                    },
                    {
                        title: 'Fecha de fin',
                        data: 'fecha_fin',
                        render: (data) => {
                            return dayjs(data).format('DD/MM/YYYY');
                        }
                    },
                    {
                        title: 'Estado',
                        data: 'estado',
                        render: (data, type, row) => {
                            if (data == 1) {
                                return `<button class="btn btn-success" onclick="cerrarGestion(${row.id_gestion})"
                                >ABIERTO</button>`;
                            }
                            return `<button class="btn btn-danger" onclick="abrirGestion(${row.id_gestion})">CERRADO</button>`;
                        }
                    }, {
                        "title": 'Acciones',
                        "data": 'id_gestion',
                        render: (data, type, row) => {
                            return `<button data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalgestion" onclick="editarModal('${data}', '${row.nombre}', '${row.fecha_inicio}', '${row.fecha_fin}')"><i class="bi bi-pen"></i></button>
                                    <button data-toggle="tooltip" data-placement="top" title="Calendario" class="btn btn-outline-warning" onclick="encontrarYRemplazarPorPeriodo('${data}')"><i class="bi bi-calendar"></i></button>`
                        }
                    }
                ]
            });
        });
    </script>
@endsection
