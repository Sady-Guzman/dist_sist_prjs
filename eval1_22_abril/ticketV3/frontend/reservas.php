<?php 
include "../backend/conexion.php"; 
session_start();
$usuario=$_SESSION['usuario'];
if (!isset($_SESSION['usuario']) || !isset($_SESSION['clave'])) {
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>CRUD Reservas</title>

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
</head>
<body class="container py-4">
<button type="button" class="btn btn-outline-secondary rounded-circle p-2"  > <i class="bi bi-person"><?php echo $usuario;?></i></button>
<a href="logout.php" class="btn btn-outline-secondary mb-2">Cerrar sesión</a>
<br>
<hr>
    <h2>Reservas</h2>
    <button id="nuevaReserva" class="btn btn-success mb-3">Nueva Reserva</button>

    <table id="tablaReservas" class="display table table-striped" style="width:100%">
        <thead>
            <tr>
                <th>ID</th>
                <th>Fecha</th>
                <th>Cliente</th>
                <th>Asiento</th>
                <th>Usuario</th>
                <th>Acciones</th>
            </tr>
        </thead>
    </table>

    <!-- Modal Bootstrap -->
    <div class="modal fade" id="modalReserva" tabindex="-1" aria-labelledby="modalReservaLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="formReserva">
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalReservaLabel">Reserva</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Cerrar"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="reserva_cod" id="reserva_cod">
                        <div class="mb-3">
                            <label for="fecha" class="form-label">Fecha</label>
                            <input type="datetime-local" class="form-control" name="fecha" id="fecha">
                        </div>
                        <div class="mb-3">
                            <label for="cliente" class="form-label">Cliente</label>
                            <input type="text" class="form-control" name="cliente" id="cliente">
                        </div>
                        <div class="mb-3">
                            <label for="asiento_cod" class="form-label">Asiento</label>
                            <select class="form-select" name="asiento_cod" id="asiento_cod"></select>
                        </div>
                        <div class="mb-3">
                            <label for="usuario_cod" class="form-label">Usuario</label>
                            <select class="form-select" name="usuario_cod" id="usuario_cod"></select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Guardar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function () {
            const modalReserva = new bootstrap.Modal(document.getElementById('modalReserva'));

            const tabla = $('#tablaReservas').DataTable({
                ajax: "reservas_crud.php?op=read",
                columns: [
                    { data: "reserva_cod" },
                    { data: "fecha" },
                    { data: "cliente" },
                    { data: "asiento" },
                    { data: "usuario" },
                    {
                        data: null,
                        render: function (data) {
                            return `
                                <button class="btn btn-sm btn-warning editar" data-id="${data.reserva_cod}">Editar</button>
                                <button class="btn btn-sm btn-danger eliminar" data-id="${data.reserva_cod}">Eliminar</button>`;
                        }
                    }
                ]
            });

            function cargarSelects() {
                $.get("reservas_crud.php?op=get_asientos", data => {
                    $("#asiento_cod").html(data);
                });
                $.get("reservas_crud.php?op=get_usuarios", data => {
                    $("#usuario_cod").html(data);
                });
            }

            $("#nuevaReserva").on("click", function () {
                $("#formReserva")[0].reset();
                $("#reserva_cod").val("");
                cargarSelects();
                modalReserva.show();
            });

            $('#tablaReservas').on('click', '.editar', function () {
                let id = $(this).data('id');
                $.get("reservas_crud.php?op=edit&id=" + id, function (data) {
                    let r = JSON.parse(data);
                    $("#reserva_cod").val(r.reserva_cod);
                    $("#fecha").val(r.fecha.replace(" ", "T"));
                    $("#cliente").val(r.cliente);
                    cargarSelects();
                    setTimeout(() => {
                        $("#asiento_cod").val(r.asiento_cod);
                        $("#usuario_cod").val(r.usuario_cod);
                    }, 200);
                    modalReserva.show();
                });
            });

            $('#tablaReservas').on('click', '.eliminar', function () {
                if (confirm("¿Eliminar reserva?")) {
                    $.post("reservas_crud.php?op=delete", { id: $(this).data('id') }, function () {
                        tabla.ajax.reload();
                    });
                }
            });

            $('#formReserva').submit(function (e) {
                e.preventDefault();
                $.post("reservas_crud.php?op=save", $(this).serialize(), function () {
                    tabla.ajax.reload();
                    modalReserva.hide();
                });
            });
        });
    </script>
</body>
</html>
