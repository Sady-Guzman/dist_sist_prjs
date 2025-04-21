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
    $res = $conn->query("SELECT asiento_cod, asiento FROM asientos");
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
        $conn->query("INSERT INTO reservas (fecha, cliente, asiento_cod, usuario_cod)
                      VALUES ('$fecha', '$cliente', $asiento, $usuario)");
    } else {
        $conn->query("UPDATE reservas SET fecha='$fecha', cliente='$cliente', 
                      asiento_cod=$asiento, usuario_cod=$usuario WHERE reserva_cod=$id");
    }
}

if ($op == "edit") {
    $id = $_GET["id"];
    $r = $conn->query("SELECT * FROM reservas WHERE reserva_cod = $id")->fetch_assoc();
    echo json_encode($r);
}

if ($op == "delete") {
    $id = $_POST["id"];
    $conn->query("DELETE FROM reservas WHERE reserva_cod = $id");
}
