<? 

namespace Application\Excel;


require_once 'PHPExcel.php';


// use Application\Excel\PHPExcel_IOFactory;
/**
 *
 * @author joseluis
 *
 */

class SimpleListReport extends \PHPExcel{
	
	/**
	 * 
	 * @var int
	 */
	const GlobalFontsize = 10;
	/**
	 * 
	 * @var int
	 */
	const GlobalTitleSize = 18;
// 	const GlobalAlign =
	/**
	 * 
	 * @var unknown_type
	 */
	const DocumentTitle = '';
	/**
	 * 
	 * @var int
	 */
	const ColumnMini = 5;
	/**
	 *
	 * @var int
	 */
	const ColumnSmall = 10;
	/**
	 *
	 * @var int
	 */
	const ColumnMedium = 20;
	/**
	 *
	 * @var int
	 */
	const ColumnBig = 30;
	/**
	 *
	 * @var int
	 */
	const ColumnBiggest = 40;
	/**
	 *
	 * @var string
	 */
	private $tableTitle = "Excel Report";
	/**
	 *
	 * @var array
	 */
	private $tableHeaders = array();
	/**
	 * 
	 * @var int
	 */
	private $tableHeadersHeight = 1;
	/**
	 *
	 * @var array
	 */
	private $tableContent = array();
	/**
	 * 
	 * @var array
	 */
	private $tableColumnsFormat = array();
	/**
	 * 
	 * @var array
	 */
	private $tableColumnsWidth = array();
	/**
	 * 
	 * @var string
	 */
	private $filename = 'excel_report';
	/**
	 * 
	 * @var string
	 */
	private $contentType = 'Content-Type: application/vnd.ms-excel';
	/**
	 * 
	 * @var string
	 */
	private $contentDisposition = 'Content-Disposition: attachment';
	/**
	 * 
	 * @var string
	 */
	private $cacheControl = 'Cache-Control: max-age=0';
	/**
	 * 
	 * @var int
	 */
	
	/**
	 * 
	 * @var PHPExcel_Worksheet
	 */
	private $activeSheet;
	/**
	 *
	 * @return string
	 */
	public function getTableTitle(){
		return $this->tableTitle;
	}
	/**
	 *
	 * @param string $tableHeaders
	 */
	public function setTableTitle($tableTitle){
		$this->tableTitle = $tableTitle;
	}
	/**
	 *
	 * @return array
	 */
	public function getTableHeaders(){
		return $this->tableHeaders;
	}
	/**
	 *
	 * @param array $tableHeaders
	 */
	public function setTableHeaders(array $tableHeaders){
		$this->tableHeaders = $tableHeaders;
	}
	/**
	 * The value is not in pixeles it will multiplies the current row height
	 * @return array
	 */
	public function getTableHeadersHeight(){
		return $this->tableHeadersHeight;
	}
	/**
	 * The value is not in pixeles it will multiplies the current row height
	 * @param array $tableHeadersHeight
	 */
	public function setTableHeadersHeight($tableHeadersHeight){
		$this->tableHeadersHeight = $tableHeadersHeight;
	}
	/**
	 *
	 * @return array
	 */
	public function getTableContent(){
		return $this->tableContent;
	}
	/**
	 *
	 * @param array $tableHeaders
	 */
	public function setTableContent(array $tableContent){
		$this->tableContent = $tableContent;
	}
	/**
	 *
	 * @return array
	 */
	public function getTableColumnsFormat(){
		return $this->tableColumnsFormat;
	}
	/**
	 *
	 * @param array $tableColumnsFormat
	 */
	public function setTableColumnsFormat(array $tableColumnsFormat){
		$this->tableColumnsFormat = $tableColumnsFormat;
	}
	/**
	 *
	 * @return array
	 */
	public function getTableColumnsWidth(){
		return $this->tableColumnsWidth;
	}
	/**
	 * The values can be: <ul><li>Custom (Numeric)</li><li>mini</li><li>small</li><li>medium</li><li>big</li><li>biggest</li></ul>
	 * @param array $tableColumnsWidth
	 */
	public function setTableColumnsWidth(array $tableColumnsWidth){
		$this->tableColumnsWidth = $tableColumnsWidth;
	}
	/**
	 *
	 * @return string
	 */
	public function getFilename(){
		return $this->filename;
	}
	/**
	 *
	 * @param string $tableHeaders
	 */
	public function setFilename($filename){
		if (!empty($filename))
			$this->filename =  $filename;
	}
	/**
	 * Sets the contentType e.g. in mime-like format
	 * @param string $contentType
	 */
	public function setContentType($contentType){
		if (!empty($contentType))
			$this->contentType = 'Content-Type: '. $contentType;
	}
	/**
	 * 
	 * @return string
	 */
	public function getContentType(){
		return $this->contentType;
	}
	/**
	 * just sets the content disposition param for headers
	 * @param string $contentDisposition
	 */
	public function setContentDisposition($contentDisposition){
		if (!empty($contentDisposition))
			$this->contentDisposition = 'Content-Disposition: ' . $contentDisposition;
	}
	/**
	 * returns the complete header for content disposition including filename
	 * @return string
	 */
	public function getContentDisposition(){
		return $this->contentDisposition.'; '.'filename="'.$this->getFilename().'.xlsx"';
	}
	/**
	 * Sets the header's param for cache control
	 * @param string $cacheControl
	 */
	
	public function setCacheControl($cacheControl){
		if (!empty($cacheControl))
			$this->contentType = 'Cache-Control: '. $cacheControl;
	}
	/**
	 *
	 * @return string
	 */
	public function getCacheControl(){
		return $this->cacheControl;
	}
	
	/**
	 * 
	 */
	public function createSpreadsheet(){
		
		$activeSheet = $this->setActiveSheetIndex(0);
		$this->getProperties()
		->setCreator($creator)
		->setTitle($this->getTableTitle())
		->setSubject($this->getTableTitle())
		->setDescription($this->getTableTitle());
		
		$activeSheet->getDefaultStyle()->getFont()->setSize(self::GlobalFontsize);
		$activeSheet->getDefaultStyle()->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
		$activeSheet->getDefaultStyle()->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
		$activeSheet->getDefaultStyle()->getAlignment()->setVertical(\PHPExcel_Style_Alignment::VERTICAL_TOP);
		$columns = range('A', 'Z');
		$lastColumn = count($this->getTableHeaders()) - 1;
		$activeSheet->mergeCells('A1:'.$columns[$lastColumn].'1')
		->setCellValue('A1', $this->getTableTitle())->getStyleByColumnAndRow(0,1)->getFont()->setSize(self::GlobalTitleSize);
		$activeSheet->getStyleByColumnAndRow(0,1)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
		$activeSheet->getRowDimension(1)->setRowHeight(self::GlobalTitleSize + self::GlobalTitleSize/2);
		foreach ($this->getTableHeaders() as $key => $header){
			$column = $columns[$key];
		 	$row = ('3');
			$cell = $column . $row;
			$activeSheet->getColumnDimension($column)->setWidth($this->getColumnWidth($key));
			$activeSheet->getRowDimension($row)->setRowHeight((self::GlobalFontsize + self::GlobalFontsize/2)*$this->getTableHeadersHeight());
			$activeSheet->setCellValue($cell, $header);
			$activeSheet->getStyleByColumnAndRow($key,$row)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
			$activeSheet->getStyleByColumnAndRow($key,$row)->getAlignment()->setWrapText(true);
			
		}
		$row = 4;
		foreach ($this->getTableContent() as $rows){
// 			$activeSheet->getRowDimension($row)->setRowHeight(self::GlobalFontsize + self::GlobalFontsize/2);
			foreach ($rows as $key => $value){
				$column = $columns[$key];
				$cell = $column . $row;
				$activeSheet->getColumnDimension($column)->setWidth($this->getColumnWidth($key));
// 				$activeSheet->setCellValue($cell, $value);
				$activeSheet->getCell($cell)->setValueExplicit($value,\PHPExcel_Cell_DataType::TYPE_STRING);
// 				$activeSheet->getStyle($cell)->getNumberFormat()->setFormatCode(\PHPExcel_Style_NumberFormat::FORMAT_TEXT);
				$activeSheet->getStyleByColumnAndRow($key,$row)->getAlignment()->setWrapText(true);
			}
			$row++;
		}
		header($this->getContentType());
		header($this->getContentDisposition());
		header($this->getCacheControl());
		$objWriter = \PHPExcel_IOFactory::createWriter($this, 'Excel2007');
		$objWriter->save("php://output");
		exit();
	}
	private function getColumnWidth($column){
		if (empty($this->tableColumnsWidth) || empty($this->tableColumnsWidth[$column])) return self::ColumnMedium;
		else{
			switch ($this->tableColumnsWidth[$column]){
				case is_numeric($this->tableColumnsWidth[$column]): return $this->tableColumnsWidth[$column];
				break;
				case 'mini': return self::ColumnMini;
				break;
				case 'small': return self::ColumnSmall;
				break;
				case 'medium': return self::ColumnMedium;
				break;
				case 'big': return self::ColumnBig;
				break;
				case 'biggest': return self::ColumnBiggest;
				break;
				default: return self::ColumnMedium;
			}
		}
	}
	private function getColumnFormat($column){
		return (empty($this->tableColumnsFormat) || empty($this->tableColumnsFormat[$column])) ?  '' : $this->tableColumnsFormat[$column];
	} 
}