<div class="modal fade" id="modalgestion" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-s">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="titleModalGestion" class="modal-title text-dark">Nueva Gestión</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form autocomplete="off" id="registrar_form" method="POST" action="{{ route('registrar_g') }}"
                    class="card-body cardbody-color p-5">
                    @csrf
                    <input hidden id="id_empresa" name="id_empresa" value="{{ $usuario->empresas[0]->id_empresa }}" />
                    <input hidden id="id_gestion" name="id_gestion" value="" />
                    <div class="row m-3 mt-0">
                        <div class="col-sm-3">
                            <label class="h5">Nombre:</label>
                        </div>
                        <div class="col-sm-8 ms-4">
                            <input required type="text"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                onkeypress="return /[A-Z ]/i.test(event.key)" maxlength="15" class="form-control"
                                id="nombre" name="nombre">
                        </div>
                    </div>
                    <div class="row m-3 mt-0">
                        <div class="col-sm-3">
                            <label class="h5">Fecha Inicio:</label>
                        </div>
                        <div class="col-sm-8 ms-4">
                            <input required type="date" class="form-control" id="fecha_inicio" name="fecha_inicio">
                        </div>
                    </div>
                    <div class="row m-3 mt-0">
                        <div class="col-sm-3">
                            <label class="h5">Fecha Fin:</label>
                        </div>
                        <div class="col-sm-8 ms-4">
                            <input required type="date" class="form-control" id="fecha_fin" name="fecha_fin">
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="btnGestion" onclick="sendDataGestion()" type="button"
                    class="btn btn-primary">Grabar</button><button type="button" class="btn btn-danger"
                    data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
<script>
    let agregarGestion = () => {
        $('#titleModalGestion').html("Nueva Gestión")
        $('#nombre').val("");
        $('#fecha_inicio').val("");
        $('#fecha_fin').val("");
        $('#btnGestion').html("Grabar")
        $('#btnGestion').removeClass('btn-warning').addClass('btn-primary');
    };
    let sendDataGestion = () => {
        let crear = '{{ route('registrar_g') }}';
        let editar = '{{ route('editar_g') }}';
        let url = '';
        if ($('#btnGestion').html() == "Grabar") {
            url = crear;
        } else {
            url = editar;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: $('#registrar_form').serialize(),
            success: function(data) {
                if (data.success == true) {
                    if ($('#btnGestion').html() == "Grabar") {
                        Notify.success('La gestión se ha creado correctamente');

                    } else {
                        Notify.success('La gestión se ha editado correctamente');

                    }
                    reload();
                }
            },
            error: function(data) {
                Notify.failure(data.responseJSON.message);
            }
        });
    };
</script>
