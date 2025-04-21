<?php
include "../backend/conexion.php";

$op = $_GET['op'] ?? '';

if ($op == "read") {
    header('Content-Type: application/json');

    $sql = "SELECT r.reserva_cod, r.fecha, r.cliente, r.asiento_cod, r.usuario_cod,
                   a.asiento, u.usuario
            FROM reservas r
            JOIN asientos a ON r.asiento_cod = a.asiento_cod
            JOIN usuarios u ON r.usuario_cod = u.usuario_cod";

    $result = $conn->query($sql);
    $data = [];

    while ($row = $result->fetch_assoc()) {
        $data[] = $row;
    }

    echo json_encode(["data" => $data]);
}

if ($op == "get_asientos") {
    // Only get seats that are not occupied
    $res = $conn->query("SELECT asiento_cod, asiento FROM asientos WHERE ocupado = 0");
    while ($r = $res->fetch_assoc()) {
        echo "<option value='{$r['asiento_cod']}'>{$r['asiento']}</option>";
    }
}

if ($op == "get_usuarios") {
    $res = $conn->query("SELECT usuario_cod, usuario FROM usuarios");
    while ($r = $res->fetch_assoc()) {
        echo "<option value='{$r['usuario_cod']}'>{$r['usuario']}</option>";
    }
}

if ($op == "save") {
    $id = $_POST["reserva_cod"];
    $fecha = $_POST["fecha"];
    $cliente = $_POST["cliente"];
    $asiento = $_POST["asiento_cod"];
    $usuario = $_POST["usuario_cod"];

    if ($id == "") {
        // INSERT new reservation
        $insert = $conn->query("INSERT INTO reservas (fecha, cliente, asiento_cod, usuario_cod)
                                VALUES ('$fecha', '$cliente', $asiento, $usuario)");

        if ($insert) {
            // Mark the seat as occupied
            $conn->query("UPDATE asientos SET ocupado = 1 WHERE asiento_cod = $asiento");
        }
    } else {
        // Get the old seat assigned to the reservation (to free it if changed)
        $res = $conn->query("SELECT asiento_cod FROM reservas WHERE reserva_cod = $id");
        $row = $res->fetch_assoc();
        $old_asiento = $row['asiento_cod'];

        // UPDATE reservation
        $update = $conn->query("UPDATE reservas SET fecha='$fecha', cliente='$cliente',
                               asiento_cod=$asiento, usuario_cod=$usuario WHERE reserva_cod=$id");

        if ($update) {
            // Free the old seat
            $conn->query("UPDATE asientos SET ocupado = 0 WHERE asiento_cod = $old_asiento");

            // Mark the new one as occupied
            $conn->query("UPDATE asientos SET ocupado = 1 WHERE asiento_cod = $asiento");
        }
    }
}

if ($op == "edit") {
    $id = $_GET["id"];
    $r = $conn->query("SELECT * FROM reservas WHERE reserva_cod = $id")->fetch_assoc();
    echo json_encode($r);
}

if ($op == "delete") {
    $id = $_POST["id"];

    // Get seat to free it
    $res = $conn->query("SELECT asiento_cod FROM reservas WHERE reserva_cod = $id");
    if ($res && $res->num_rows > 0) {
        $row = $res->fetch_assoc();
        $asiento = $row['asiento_cod'];

        // Delete reservation
        $conn->query("DELETE FROM reservas WHERE reserva_cod = $id");

        // Free the seat
        $conn->query("UPDATE asientos SET ocupado = 0 WHERE asiento_cod = $asiento");
    }
}
?>