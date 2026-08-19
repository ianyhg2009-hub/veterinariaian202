<?php

class ConexionDB {
    private $host = "localhost";
    private $db_name = "santuario_mascotas";
    private $username = "root";
    private $password = "";
    protected $conexion;

    public function conectar() {
        $this->conexion = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conexion = new PDO($dsn, $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            // Manejo seguro de excepciones en la conexión
            throw new Exception("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }
}


class Mascota {
    protected $nombre;
    protected $especie;
    protected $raza;
    protected $edad;
    protected $pesoActual;
    protected $colorSenas;
    protected $nombreResponsable;
    protected $telefonoEmergencia;

    public function __construct($nombre, $especie, $raza, $edad, $pesoActual, $colorSenas, $nombreResponsable, $telefonoEmergencia) {
        $this->nombre = $nombre;
        $this->especie = $especie;
        $this->raza = $raza;
        $this->edad = (int)$edad;
        $this->setPesoActual($pesoActual); // Usa el setter para validar al instanciar
        $this->colorSenas = $colorSenas;
        $this->nombreResponsable = $nombreResponsable;
        $this->telefonoEmergencia = $telefonoEmergencia;
    }

    public function getNombre() { return $this->nombre; }
    public function getEspecie() { return $this->especie; }
    public function getRaza() { return $this->raza; }
    public function getEdad() { return $this->edad; }
    public function getPesoActual() { return $this->pesoActual; }
    public function getColorSenas() { return $this->colorSenas; }
    public function getNombreResponsable() { return $this->nombreResponsable; }
    public function getTelefonoEmergencia() { return $this->telefonoEmergencia; }

    public function setNombre($nombre) { $this->nombre = $nombre; }
    public function setEspecie($especie) { $this->especie = $especie; }
    public function setRaza($raza) { $this->raza = $raza; }
    public function setEdad($edad) { $this->edad = (int)$edad; }

    public function setPesoActual($pesoActual) {
        if (!is_numeric($pesoActual) || $pesoActual <= 0) {
            throw new InvalidArgumentException("Error: El peso debe ser un número positivo mayor que cero.");
        }
        $this->pesoActual = (float)$pesoActual;
    }

    public function setColorSenas($colorSenas) { $this->colorSenas = $colorSenas; }
    public function setNombreResponsable($nombreResponsable) { $this->nombreResponsable = $nombreResponsable; }
    public function setTelefonoEmergencia($telefonoEmergencia) { $this->telefonoEmergencia = $telefonoEmergencia; }
}

class LimpiadorEntradas {
    public static function limpiar($dato) {
        if (is_null($dato)) return "";
        $dato = trim($dato);                
        $dato = stripslashes($dato);         
        $dato = htmlspecialchars($dato, ENT_QUOTES, 'UTF-8');  
        return $dato;
    }
}

class MascotaRepository extends ConexionDB {

    public function guardarMascota(Mascota $mascota) {
        try {
            $db = $this->conectar();

            $sql = "INSERT INTO Mascotas (nombre, especie, raza, edad, peso_actual, color_senas, nombre_responsable, telefono_emergencia) 
                    VALUES (:nombre, :especie, :raza, :edad, :peso, :color_senas, :responsable, :telefono)";

            $stmt = $db->prepare($sql);


            $stmt->bindValue(':nombre', $mascota->getNombre());
            $stmt->bindValue(':especie', $mascota->getEspecie());
            $stmt->bindValue(':raza', $mascota->getRaza());
            $stmt->bindValue(':edad', $mascota->getEdad(), PDO::PARAM_INT);
            $stmt->bindValue(':peso', $mascota->getPesoActual());
            $stmt->bindValue(':color_senas', $mascota->getColorSenas());
            $stmt->bindValue(':responsable', $mascota->getNombreResponsable());
            $stmt->bindValue(':telefono', $mascota->getTelefonoEmergencia());

            return $stmt->execute();

        } catch (PDOException $e) {
            throw new Exception("Error en la base de datos al registrar el paciente: " . $e->getMessage());
        }
    }
}
class ConexionDB {
    private $host = "sqlXXX.infinityfree.com"; 
    private $db_name = "if0_XXXXXXXX_santuario_mascotas"; // <-- Poner nombre completo de tu BD
    private $username = "if0_XXXXXXXX"; // <-- Poner tu usuario de BD
    private $password = "TU_CONTRASEÑA_DE_HOSTING"; // <-- Tu contraseña
    protected $conexion;

    public function conectar() {
        $this->conexion = null;
        try {
            $dsn = "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4";
            $this->conexion = new PDO($dsn, $this->username, $this->password);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->conexion;
        } catch (PDOException $e) {
            throw new Exception("Error al conectar con la base de datos: " . $e->getMessage());
        }
    }
}

// ==========================================
// FLUJO PRINCIPAL DEL SISTEMA (EJECUCIÓN)
// ==========================================

// Paso 1: Recibir datos crudos (Simulación de entrada de formulario o API)
$datosEntrada = [
    'nombre'              => "  <script>alert('hack')</script> Rocky  ",
    'especie'             => "Canino ",
    'raza'                => " Pastor Alemán\ ",
    'edad'                => " 4 ",
    'peso_actual'         => " 28.50 ",
    'color_senas'         => "Mancha negra en el lomo y oreja izquierda caída. ",
    'nombre_responsable'  => " María López ",
    'telefono_emergencia' => " +504 9999-8888 "
];

echo "<h2>Procesando Registro de Mascota...</h2>";

try {
    // Paso 2: Limpiar la información ingresada
    $nombreLimpio      = LimpiadorEntradas::limpiar($datosEntrada['nombre']);
    $especieLimpia     = LimpiadorEntradas::limpiar($datosEntrada['especie']);
    $razaLimpia        = LimpiadorEntradas::limpiar($datosEntrada['raza']);
    $edadLimpia        = LimpiadorEntradas::limpiar($datosEntrada['edad']);
    $pesoLimpio        = LimpiadorEntradas::limpiar($datosEntrada['peso_actual']);
    $colorLimpio       = LimpiadorEntradas::limpiar($datosEntrada['color_senas']);
    $responsableLimpio = LimpiadorEntradas::limpiar($datosEntrada['nombre_responsable']);
    $telefonoLimpio    = LimpiadorEntradas::limpiar($datosEntrada['telefono_emergencia']);

    // Pasos 3 y 4: Crear objeto Mascota y validar peso
    $mascota = new Mascota(
        $nombreLimpio,
        $especieLimpia,
        $razaLimpia,
        $edadLimpia,
        $pesoLimpio,
        $colorLimpio,
        $responsableLimpio,
        $telefonoLimpio
    );

    // Pasos 5 y 6: Establecer conexión e insertar mediante herencia y consulta preparada
    $repositorio = new MascotaRepository();
    $exito = $repositorio->guardarMascota($mascota);

    // Paso 7: Mensaje de resultado
    if ($exito) {
        echo "<p style='color: green;'><strong>¡Éxito!</strong> La mascota '{$mascota->getNombre()}' ha sido registrada exitosamente en el expediente maestro.</p>";
    }

} catch (InvalidArgumentException $e) {
    // Captura de errores de validación (por ejemplo, peso <= 0)
    echo "<p style='color: red;'><strong>Error de Validación:</strong> " . $e->getMessage() . "</p>";

} catch (Exception $e) {
    // Captura de errores generales y de base de datos
    echo "<p style='color: red;'><strong>Error del Sistema:</strong> " . $e->getMessage() . "</p>";
}