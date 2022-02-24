<div class="modal fade" id="modalempresa" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 id="titleModalEmpresa" class="modal-title text-dark">Nueva Empresa</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="registrar_empresa" autocomplete="off" method="POST" action="{{ route('registrar_e') }}"
                    class="card-body cardbody-color p-5">
                    @csrf
                    <div class="row m-3 mt-0">
                        <div class="col-sm-3">
                            <label class="h5">Nombre:</label>
                        </div>
                        <div class="col-sm-5">
                            <input required type="text"
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                onkeypress="return /[A-Z 0-9]/i.test(event.key)" maxlength="15" class="form-control"
                                id="nombre" name="nombre">
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-sm-3">
                            <label class="h5">NIT:</label>
                        </div>
                        <div class="col-sm-5">
                            <input required
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxlength="8" type="text" onkeypress="return /[0-9]/i.test(event.key)"
                                class="form-control" id="nit" name="nit">
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col">
                            <label class="h5">Sigla:</label>
                        </div>
                        <div class="col">
                            <input required
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxlength="10" type="text" class="form-control" id="sigla" name="sigla">
                        </div>
                        <div class="col">
                            <label class="h5">Telefono:</label>
                        </div>
                        <div class="col">
                            <input required
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxlength="8" type="text" onkeypress="return /[0-9]/i.test(event.key)"
                                class="form-control" id="telefono" name="telefono">
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col">
                            <label class="h5">Correo:</label>
                        </div>
                        <div class="col">
                            <input required type="text" class="form-control" id="correo" name="correo">
                        </div>
                        <div class="col">
                            <label class="h5">Niveles:</label>
                        </div>
                        <div class="col">
                            <select type="text" class="form-select" id="niveles" name="niveles">
                                <option selected value="3">3</option>
                                <option value="4">4</option>
                                <option value="5">5</option>
                                <option value="6">6</option>
                                <option value="7">7</option>
                            </select>
                        </div>
                    </div>
                    <div class="row m-3">
                        <div class="col-sm-3">
                            <label class="h5">Dirección:</label>
                        </div>
                        <div class="col-sm-7">
                            <textarea required
                                oninput="javascript: if (this.value.length > this.maxLength) this.value = this.value.slice(0, this.maxLength);"
                                maxlength="150" class="form-control" name="direccion" id="direccion"
                                rows="3"></textarea>
                        </div>
                    </div>
            </div>
            <div class="modal-footer">
                <button id="btnEmpresa" onclick="editarEmpresa()" type="button" class="btn btn-primary"></button>
                <button type="button" class="btn btn-danger" data-bs-dismiss="modal">Cerrar</button>
            </div>
            </form>
        </div>
    </div>
</div>
