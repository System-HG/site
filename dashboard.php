<?php require "config/sesion.php"; verificarSesion(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Sistema de Cobros de Agua</title>
    <link rel="stylesheet" href="assets/css/estilos.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body>
    <div class="contenedor-principal">
        <!-- Botón menú móvil -->
        <button class="boton-menu-movil" id="btnMenu">
            <i class="fas fa-bars"></i> Menú
        </button>

        <!-- Menú lateral -->
        <aside class="menu-lateral" id="menuLateral">
            <div class="perfil">
                <i class="fas fa-user-circle"></i>
                <p><?= $_SESSION['nombre'] ?></p>
                <small><?= $_SESSION['rol'] === 'administrador' ? 'Administrador' : 'Contadora' ?></small>
            </div>
            
            <nav>
                <ul>
                    <li><a href="dashboard.php" class="activo"><i class="fas fa-home"></i> Inicio</a></li>
                    
                    <li class="grupo-menu">
                        <span class="titulo-grupo"><i class="fas fa-users"></i> Clientes</span>
                        <ul class="submenu">
                            <li><a href="clientes/registrar.php">Registrar cliente</a></li>
                            <li><a href="clientes/listar.php">Lista y actualización</a></li>
                            <li><a href="clientes/exportar_pdf.php">Exportar datos PDF</a></li>
                        </ul>
                    </li>
                    
                    <li class="grupo-menu">
                        <span class="titulo-grupo"><i class="fas fa-file-invoice-dollar"></i> Facturación</span>
                        <ul class="submenu">
                            <li><a href="facturacion/registrar_pago.php">Registrar pago</a></li>
                            <li><a href="facturacion/multas.php">Multas</a></li>
                            <li><a href="facturacion/historial.php">Historial de pagos</a></li>
                        </ul>
                    </li>
                    
                    <li><a href="ingresos_egresos/index.php"><i class="fas fa-coins"></i> Ingresos y Egresos</a></li>
                    <li><a href="reportes/index.php"><i class="fas fa-chart-bar"></i> Reportes</a></li>
                    
                    <li class="grupo-menu">
                        <span class="titulo-grupo"><i class="fas fa-hand-holding-heart"></i> Reuniones y Mingas</span>
                        <ul class="submenu">
                            <li><a href="reuniones/asistencia.php">Asistencia</a></li>
                            <li><a href="reuniones/asistencia.php">Asistencia</a></li>
                        </ul>
                    </li>
                    
                    <li class="grupo-menu">
                        <span class="titulo-grupo"><i class="fas fa-cog"></i> Configuración</span>
                        <ul class="submenu">
                            <?php if ($_SESSION['rol'] === 'administrador'): ?>
                                <li><a href="configuracion/usuarios.php">Usuarios</a></li>
                                <li><a href="configuracion/restricciones.php">Restricciones</a></li>
                            <?php else: ?>
                                <li><a href="#" onclick="alert('Solo administradores'); return false;">Usuarios</a></li>
                            <?php endif; ?>
                        </ul>
                    </li>
                    
                    <li><a href="logout.php" class="cerrar-sesion"><i class="fas fa-sign-out-alt"></i> Cerrar Sesión</a></li>
                </ul>
            </nav>
        </aside>

        <!-- Contenido principal -->
        <main class="contenido">
            <h1>📊 Panel de Control</h1>
            
            <?php
            require "config/bd.php";
            // Estadísticas
            $clientes = $conexion->query("SELECT COUNT(*) as total FROM clientes")->fetch_assoc()['total'];
            $multas_pagar = $conexion->query("SELECT COALESCE(SUM(monto),0) as total FROM multas WHERE estado='vigente'")->fetch_assoc()['total'];
            $mingas = $conexion->query("SELECT COUNT(*) as total FROM reuniones_mingas WHERE tipo='minga'")->fetch_assoc()['total'];
            $ingresos = $conexion->query("SELECT COALESCE(SUM(monto),0) as total FROM ingresos")->fetch_assoc()['total'];
            $egresos = $conexion->query("SELECT COALESCE(SUM(monto),0) as total FROM egresos")->fetch_assoc()['total'];
            ?>
            
            <div class="tarjetas">
                <div class="tarjeta azul">
                    <h3>👥 Clientes</h3>
                    <p class="numero"><?= $clientes ?></p>
                </div>
                <div class="tarjeta rojo">
                    <h3>⚠️ Multas por cobrar</h3>
                    <p class="numero">$<?= number_format($multas_pagar, 2) ?></p>
                </div>
                <div class="tarjeta verde">
                    <h3>🤝 Mingas realizadas</h3>
                    <p class="numero"><?= $mingas ?></p>
                </div>
                <div class="tarjeta dorado">
                    <h3>💰 Ingresos</h3>
                    <p class="numero">$<?= number_format($ingresos, 2) ?></p>
                </div>
                <div class="tarjeta naranja">
                    <h3>📉 Egresos</h3>
                    <p class="numero">$<?= number_format($egresos, 2) ?></p>
                </div>
                <div class="tarjeta morado">
                    <h3>💵 Balance</h3>
                    <p class="numero">$<?= number_format($ingresos - $egresos, 2) ?></p>
                </div>
            </div>
        </main>
    </div>
    
    <script src="assets/js/funciones.js"></script>
</body>
</html>