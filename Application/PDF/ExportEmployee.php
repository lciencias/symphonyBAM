<?php
namespace Application\PDF;
/**
 *
 */
use Application\Model\Collection\EmployeeCollection;
use Application\Query\PositionQuery;
use Application\Query\AreaQuery;
use Application\Query\EmployeeNominationQuery;
use Application\Query\EmployeeAssignQuery;
use Application\Model\Bean\Employee;


require_once 'FPDF/fpdf.php';



/**
 *
 * @author joseluis
 *
 */
class ExportEmployee extends \FPDF{
	/**
	 *
	 * @var string
	 */
	private $FontType = 'Arial';
	/**
	 * @var
	 */
	private $regularSize = 5;
	/**
	 *
	 * @var int
	 */
	private $headerSize = 12;
	/**
	 *
	 * @var string
	 */
	private $documentName = "Empleados.pdf";
	/**
	 *
	 * @var string
	 */
	private $outputDestination = "I";
	/**
	 *
	 * @var string
	 */
	private $orientation = 'Portrait';
	/**
	*
	*/
	private $pageUnit = 'mm';


	public function __construct(){
		parent::__construct($this->orientation, $this->pageUnit, 'Letter');
	}

	public function headerTable()
	{
		$this->SetXY(100,20);
		$this->SetFont($this->FontType, 'B', 12);
		$this->MultiCell(30, 4, utf8_decode('Empleados'),$borderT);
		$this->Image('public/images/procuradurialogo.jpg',10,8, 50,20);


	}

	public function setData(EmployeeCollection $empolyeeCollection){
		$borderT = 'T';
		$borderB = 'B';
		$x = 8;
		$y = 45;
		$nameX = 28;
		$positions = PositionQuery::create()->find();
		$areas = AreaQuery::create()->find();
		$employeeNominations = EmployeeNominationQuery::create()
		->getByEmployeeIds($empolyeeCollection->getByEmployeeIds())
		->actives();
		$employeeAdscriptions = EmployeeAssignQuery::create()->find()->actives();

		$this->AddPage();
		$this->SetFont($this->FontType, 'B', 9);
		$this->SetXY($x,$y-8);
		$this->SetFillColor(220,220,220);
		$this->MultiCell(20, 4, utf8_decode('Número de Empleado'),$borderT);
		$this->SetXY($nameX,$y-8);
		$this->MultiCell(20, 4, utf8_decode('Nombre'),$borderT);
		$this->SetXY($x+39,$y-8);
		$this->MultiCell(20, 4, utf8_decode('Apellido Materno'),$borderT);
		$this->SetXY($x+58,$y-8);
		$this->MultiCell(20, 4, utf8_decode('Apellido Paterno'),$borderT);
		$this->SetXY($x+75,$y-8);
		$this->MultiCell(60, 4, utf8_decode('Area de Adscripción'),$borderT);
		$this->SetXY($x+132,$y-8);
		$this->MultiCell(60, 4, utf8_decode('Puesto'),$borderT);
		$this->SetXY($x+174,$y-8);
		$this->MultiCell(26, 4, utf8_decode('Status'),$borderT);

		while($empolyeeCollection->valid()){
			$employee = $empolyeeCollection->read();
			$newY = $y;
			$nomination = $employeeNominations->getByIdEmployee($employee->getIndex())->getOne();
			$position = $positions->getByPK($nomination->getIdPosition());
			$assing = $employeeAdscriptions->getByIdEmployee($employee->getIndex())->getOne();
			$area = $areas->getByPK($assing->getIdArea());

			//$this->Ln();
			$this->SetFont($this->FontType, '', 10);
			$this->SetXY($x,$y);

			$this->MultiCell(15, 4, $employee->getNumber());
			if ($newY < $this->GetY()) $newY = $this->GetY();

			$this->SetXY($x+20,$y);
  			$this->MultiCell(20, 4, utf8_decode($employee->getName()));
  			if ($newY < $this->GetY()) $newY = $this->GetY();

  			$this->SetXY($x+39,$y);
 			$this->MultiCell(22, 4,  utf8_decode($employee->getmiddleName()));
 			if ($newY < $this->GetY()) $newY = $this->GetY();

 			$this->SetXY($x+58, $y);
 			$this->MultiCell(26, 4,  utf8_decode($employee->getLastName()));
 			if ($newY < $this->GetY()) $newY = $this->GetY();

 			$this->SetXY($x+75, $y);
  			$this->MultiCell(55, 4, utf8_decode($area->getName()));
  			if ($newY < $this->GetY()) $newY = $this->GetY();

  			$this->SetXY($x+132, $y);
 			$this->MultiCell(40, 4,  utf8_decode($position->getName()));
 			if ($newY < $this->GetY()) $newY = $this->GetY();

 			$this->SetXY($x+174, $y);
 			$this->MultiCell(30, 4,  utf8_decode(Employee::$StatusTrad[$employee->getStatus()]));
 			if ($newY < $this->GetY()) $newY = $this->GetY();

 			$this->Line($x, $y, $x+200, $y);

			$y = $newY;
		}
		$this->Line($x,$y, 208,$y);//linea inferior
		$this->Line($x,37, $x,$y);//linea izquierda
		$this->Line($x+20,37, $x+20,$y);
		$this->Line($x+39,37, $x+39,$y);
		$this->Line($x+58,37, $x+58,$y);
		$this->Line($x+75,37, $x+75,$y);
		$this->Line($x+132,37, $x+132,$y);
		$this->Line($x+174,37, $x+174,$y);
		$this->Line($x+200,37, $x+200,$y);//linea derecha
	}

	public function footer()
	{

		$this->SetY(-10);

		$this->SetFont('Arial','I',8);

		$this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
	}



}