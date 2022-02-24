<div class="modal fade" id="modalperiodo" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="titleModalPeriodo" class="modal-title text-dark">Nuevo Periodo</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row m-3 mt-0">
                    <div class="col-sm-3">
                        <label class="h5">Nombre:</label>
                    </div>
                    <input id="id_periodo" hidden />
                    <div class="col-sm-8 ms-4">
                        <input required type="text"
                            oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                            onkeypress="return /[A-Z ]/i.test(event.key)" maxlength="15" class="form-control"
                            id="nombrePeriodo" name="nombrePeriodo">
                    </div>
                </div>
                <div class="row m-3 mt-0">
                    <div class="col-sm-3">
                        <label class="h5">Fecha Inicio:</label>
                    </div>
                    <div class="col-sm-8 ms-4">
                        <input required type="date" class="form-control" id="fecha_inicio_periodo"
                            name="fecha_inicio_periodo">
                    </div>
                </div>
                <div class="row m-3 mt-0">
                    <div class="col-sm-3">
                        <label class="h5">Fecha Fin:</label>
                    </div>
                    <div class="col-sm-8 ms-4">
                        <input required type="date" class="form-control" id="fecha_fin_periodo"
                            name="fecha_fin_periodo">
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button id="btnPeriodo" onclick="sendDataPeriodo()" type="button"
                    class="btn btn-primary">Grabar</button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>
<script>
    let sendDataPeriodo = () => {
        let url = '';
        if ($('#btnPeriodo').text() == 'Actualizar') {
            url = '{{ route('actualiza_periodo') }}';
        } else {
            url = '{{ route('crear_periodo') }}';
        }
        $.ajax({
            url: url,
            data: {
                _token: '{{ csrf_token() }}',
                id_periodo: $('#id_periodo').val(),
                nombre: $('#nombrePeriodo').val(),
                fecha_inicio: $('#fecha_inicio_periodo').val(),
                fecha_fin: $('#fecha_fin_periodo').val(),
                id_gestion: periodos.id_gestion //Definido en el id_gestion al hacer click del calendario
                //
            },
            type: 'POST',
            success: function(data) {
                if (data.success) {
                    Notify.success('Periodo creado/editado con exito');
                    $('#periodos').DataTable().ajax.reload();
                }
            },
            error: function(data) {
                Notify.failure(data.responseJSON.message);
            }
        });
    }

    let agregarPeriodo = () => {
        $('#titleModalPeriodo').text('Nuevo Periodo');
        $('#nombrePeriodo').val("");
        $('#fecha_inicio_periodo').val("");
        $('#fecha_fin_periodo').val("");
        $('#btnPeriodo').text('Grabar');
        $('#btnPeriodo').removeClass('btn-warning').addClass('btn-primary');
    }
    let editarPeriodoModal = (id, nombre, fecha_inicio, fecha_fin, id_gestion) => {
        $('#btnPeriodo').text('Actualizar');
        $('#btnPeriodo').removeClass('btn-primary').addClass('btn-warning');
        $('#id_periodo').val();
        $('#titleModalPeriodo').text('Editar Periodo');
        $('#nombrePeriodo').val(nombre);
        $('#fecha_inicio_periodo').val(dayjs(fecha_inicio).format('YYYY-MM-DD'));
        $('#fecha_fin_periodo').val(dayjs(fecha_fin).format('YYYY-MM-DD'));
        $('#id_periodo').val(id);
        $('#id_gestion').val(id_gestion);
    }


    let cambiarPeriodoEstado = (id) => {
        $.ajax({
            url: "{{ route('cambiarEstadoPeriodo') }}",
            type: "POST",
            data: {
                id_periodo: id,
                _token: "{{ csrf_token() }}"
            },
            success: function(data) {
                if (data.success) {
                    $('#periodos').DataTable().ajax.reload();
                }
            }
        });
    };
    const periodos = {
        id_gestion: 0,
        _token: '{{ csrf_token() }}',
        sentData: '',
        draw: '',
        length: '',
    }
    let encontrarYRemplazarPorPeriodo = (idgestion) => {
        periodos.id_gestion = idgestion;
        $('#gestionesDiv').hide();

        if ($.fn.DataTable.isDataTable('#periodos')) {
            //Ajax reload
            $('#periodos').DataTable().ajax.reload();
        } else {
            $('#periodos').DataTable({

                "language": {
                    "url": '{{ asset('datatables/spanish.json') }}'
                },
                "ajax": {
                    "type": 'POST',
                    "url": '{{ route('listarPeriodos') }}',
                    "data": function(d) {
                        periodos.sentData = JSON.stringify(d);
                        periodos.draw = d.draw;
                        periodos.length = d.length;
                        return periodos;
                    }
                },
                "serverSide": true,

                "columns": [{
                        'title': 'Nombre',
                        'data': 'nombre'
                    },
                    {
                        'title': 'Fecha Inicio',
                        'data': 'fecha_inicio',
                        render: function(data, type, row) {
                            return dayjs(data).format('DD/MM/YYYY');
                        }

                    },
                    {
                        'title': 'Fecha Fin',
                        'data': 'fecha_fin',
                        render: function(data, type, row) {
                            return dayjs(data).format('DD/MM/YYYY');
                        }
                    },
                    {
                        'title': 'Estado',
                        'data': 'estado',
                        render: (data, type, row) => {
                            if (data == 1) {
                                return `<button class="btn btn-success" onclick="cambiarPeriodoEstado(${row.id_periodo})"
                                >ABIERTO</button>`;
                            }
                            return `<button class="btn btn-danger" onclick="cambiarPeriodoEstado(${row.id_periodo})">CERRADO</button>`;
                        }
                    },
                    {
                        'title': 'Acciones',
                        'data': 'id_periodo',
                        render: (data, type, row) => {
                            return `<button data-toggle="tooltip" data-placement="top" title="Editar" class="btn btn-outline-primary" data-bs-toggle="modal" data-bs-target="#modalperiodo" onclick="editarPeriodoModal('${data}', '${row.nombre}', '${row.fecha_inicio}', '${row.fecha_fin}', '${row.id_gestion}')"><i class="bi bi-pen"></i></button>`;
                        }
                    }
                ]
            });
        }
        $('#periodosDiv').show();
    };
</script>
