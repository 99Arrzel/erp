<script>
    let editarEmpresa = () => {
        let editar = '{{ route('editEmpresa') }}';
        let crear = '{{ route('registrar_e') }}';
        let url = '';
        if ($('#btnEmpresa').html() == "Editar") {
            url = editar;
        } else {
            url = crear;
        }
        $.ajax({
            type: "POST",
            url: url,
            data: {
                id_empresa: $('#nom-empresa').val(),
                nombre: $('#nombre').val(),
                nit: $('#nit').val(),
                sigla: $('#sigla').val(),
                correo: $('#correo').val(),
                niveles: $('#niveles').val(),
                direccion: $('#direccion').val(),
                telefono: $('#telefono').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(data) {
                if (data.success == true) {
                    if ($('#btnEmpresa').html() == "Crear") {
                        Notify.success('La empresa se ha creado correctamente');
                        location.reload();
                    } else {
                        Notify.success('La empresa se ha editado correctamente');
                    }
                    location.reload();
                }
            },
            error: function(data) {
                Notify.failure(data.responseJSON.message);
            }
        });
    };


    function seleccionarCrear() {
        $('#btnEmpresa').removeClass('btn-warning').addClass('btn-primary');
        $('#btnEmpresa').html("Crear");
        $('#titleModalEmpresa').text("Crear empresa");
        $('#nombre').val("");
        $('#nit').val("");
        $('#sigla').val("");
        $('#correo').val("");
        $('#telefono').val("");
        $('#direccion').val("");
        $('#btnEmpresa').removeAttr("type").attr("type", "button")
    }

    function seleccionarEditar() {
        $('#btnEmpresa').removeAttr("type").attr("type", "button"); //Que no haga nadazanga
        $('#btnEmpresa').html("Editar");
        $('#btnEmpresa').removeClass('btn-primary').addClass('btn-warning');
        $('#titleModalEmpresa').text("Editando empresa");
        $.ajax({
            type: "POST",
            url: "{{ route('getData_e') }}",
            data: {
                id_empresa: $('#nom-empresa').val(),
                _token: '{{ csrf_token() }}'
            },
            success: function(response) {
                $('#nombre').val(response.nombre);
                $('#nit').val(response.nit);
                $('#sigla').val(response.sigla);
                $('#correo').val(response.correo);
                $('#telefono').val(response.telefono);
                $('#niveles').val(response.niveles);
                $('#direccion').val(response.direccion);

            }
        });
    }
</script>
