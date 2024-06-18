<?php
require('./fpdf/fpdf.php');

class db {
    private $host = "localhost";
    private $dbname = "spartanos";
    private $user = "root";
    private $password = "";

    public function conexion() {
        try {
            $PDO = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->dbname, $this->user, $this->password, array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
            $PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $PDO;
        } catch(PDOException $e) {
            return $e->getMessage();
        }
    }
}

// Crear una instancia de la conexión a la base de datos
$database = new db();
$conn = $database->conexion();

// Verificar si la conexión es exitosa
if (is_string($conn)) {
    die("Error en la conexión a la base de datos: " . $conn);
}

// Consulta para obtener los datos de la tabla
$sql = "SELECT doc_identidad, nombre, apellido, fecha_nacimiento, altura, peso, pie_dominante, posicion, contacto_acudiente, direccion, eps, estado_eps FROM miembro";
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Clase PDF
class PDF extends FPDF
{
    // Cabecera de página
    function Header()
    {
        $this->SetFont('Times', 'B', 14);
        $this->SetTextColor(33, 37, 41);
        $this->SetFillColor(240, 240, 240);
        $this->Rect(0, 0, 210, 297, 'F');
        $this->Image('img/triangulosrecortados.png', 10, 6, 30);
        $this->SetXY(50, 10);
        $this->MultiCell(100, 10, 'MIEMBROS ESCUELA DEPORTIVA SPARTANOS', 0, 'C');
        $this->Image('img/LogoSpartanWeb.png', 170, 6, 30);
        $this->Ln(5);
        // Añadir fecha actual
        $this->SetFont('Arial', 'I', 10);
        $this->Cell(0, 10, 'Fecha: ' . date('d/m/Y'), 0, 1, 'R');
        $this->Ln(5);
    }

    // Pie de página
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->SetTextColor(128, 128, 128);
        $this->Cell(0, 10, 'Todos los derechos reservados - Pagina ' . $this->PageNo() . '/{nb}', 0, 0, 'C');
    }

    // Función para dibujar celdas de múltiples líneas
    function Row($data, $widths)
    {
        $nb = 0;
        // Calcular el número máximo de líneas
        for ($i = 0; $i < count($data); $i++) {
            $nb = max($nb, $this->NbLines($widths[$i], $data[$i]));
        }
        $h = 5 * $nb;
        // Salto de página si es necesario
        if ($this->GetY() + $h > $this->PageBreakTrigger)
            $this->AddPage($this->CurOrientation);
        // Dibujar las celdas
        for ($i = 0; $i < count($data); $i++) {
            $w = $widths[$i];
            $x = $this->GetX();
            $y = $this->GetY();
            $this->SetDrawColor(61, 61, 61);
            $this->SetFillColor(255, 255, 255);
            $this->Rect($x, $y, $w, $h, 'DF');
            $this->MultiCell($w, 5, $data[$i], 0, 'C', false);
            $this->SetXY($x + $w, $y);
        }
        $this->Ln($h);
    }

    // Calcular el número de líneas de una celda de MultiCell
    function NbLines($w, $txt)
    {
        $cw = &$this->CurrentFont['cw'];
        if ($w == 0)
            $w = $this->w - $this->rMargin - $this->x;
        $wmax = ($w - 2 * $this->cMargin) * 1000 / $this->FontSize;
        $s = str_replace("\r", '', $txt);
        $nb = strlen($s);
        if ($nb > 0 && $s[$nb - 1] == "\n")
            $nb--;
        $sep = -1;
        $i = 0;
        $j = 0;
        $l = 0;
        $nl = 1;
        while ($i < $nb) {
            $c = $s[$i];
            if ($c == "\n") {
                $i++;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
                continue;
            }
            if ($c == ' ')
                $sep = $i;
            $l += $cw[$c];
            if ($l > $wmax) {
                if ($sep == -1) {
                    if ($i == $j)
                        $i++;
                } else
                    $i = $sep + 1;
                $sep = -1;
                $j = $i;
                $l = 0;
                $nl++;
            } else
                $i++;
        }
        return $nl;
    }
}

// Crear objeto PDF
$pdf = new PDF();
$pdf->AliasNbPages();
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 8);

// Cabecera de la tabla
$header = array(
    'Doc Identidad' => 20,
    'Nombre' => 20,
    'Apellido' => 20,
    'Fecha Nac.' => 16,
    'Altura' => 10,
    'Peso' => 10,
    'Pie Dom.' => 15,
    'Posición' => 18,
    'Contacto' => 20,
    'Dirección' => 20,
    'EPS' => 12,
    'Estado EPS' => 16
);

// Colores de las cabeceras
$pdf->SetFillColor(0, 102, 204);
$pdf->SetTextColor(255, 255, 255);
$pdf->SetDrawColor(0, 0, 0);
$pdf->SetLineWidth(.3);

foreach ($header as $col => $width) {
    $pdf->Cell($width, 7, utf8_decode($col), 1, 0, 'C', true);
}
$pdf->Ln();

// Colores de las celdas
$pdf->SetFillColor(224, 235, 255);
$pdf->SetTextColor(0);

// Datos de la tabla
$pdf->SetFont('Arial', '', 7);
$fill = false;
foreach ($result as $row) {
    $pdf->Row(array(
        $row['doc_identidad'], 
        utf8_decode($row['nombre']), 
        utf8_decode($row['apellido']), 
        $row['fecha_nacimiento'],
        $row['altura'], 
        $row['peso'], 
        utf8_decode($row['pie_dominante']), 
        utf8_decode($row['posicion']),
        $row['contacto_acudiente'], 
        utf8_decode($row['direccion']), 
        utf8_decode($row['eps']), 
        utf8_decode($row['estado_eps'])
    ), array_values($header));
    $fill = !$fill;
}

$conn = null; // Cerrar la conexión

// Output del PDF
$pdf->Output();
?>
