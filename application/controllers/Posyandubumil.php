<?php defined('BASEPATH') or exit('No direct script access allowed');

require('./vendor/autoload.php');

use PhpOffice\PhpSpreadsheet\IOFactory;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
class Posyandubumil extends MY_Controller
{

	function __construct()
	{
		$this->model = 'Posyandubumils';
		$this->page_title = 'Posyandu Ibu Hamil';
		parent::__construct();
	}

	public function index () {
		$model = $this->model;
		if ($post = $this->$model->lastSubmit($this->input->post())) {
		  if (isset ($post['delete'])) $this->$model->delete($post['delete']);
		  else {
			  $db_debug = $this->db->db_debug;
			  $this->db->db_debug = FALSE;
	
			  $result = $this->$model->save($post);
	
			  $error = $this->db->error();
			  $this->db->db_debug = $db_debug;
			  if (isset ($result['error'])) $error = $result['error'];
			  if(count($error)){
				  $this->session->set_flashdata('model_error', $error['message']);
				  redirect($this->controller);
			  }
		  }
		}
		$vars = array();
		$vars['page_name'] = 'table-posyandubumil';
		$vars['js'] = array(
		  'jquery.dataTables.min.js',
		  'dataTables.bootstrap4.js',
		  'table.js'
		);
		$vars['thead'] = $this->$model->thead;
		$this->loadview('index', $vars);
	  }

	  function download()
	  {
		  $rows = $this->Posyandubumils->download();
		  $colnames = array_keys($rows[0]);
  
		  $spreadsheet = new Spreadsheet();
		  $spreadsheet->getProperties()
			  ->setTitle('Office 2007 XLSX Test Document')
			  ->setSubject('Office 2007 XLSX Test Document')
			  ->setDescription('Test document for Office 2007 XLSX, generated using PHP classes.')
			  ->setKeywords('office 2007 openxml php')
			  ->setCategory('Test result file');
  
		  $spreadsheet->getActiveSheet()->setTitle(date('d-m-Y H'));
		  $spreadsheet->setActiveSheetIndex(0);
		  $spreadsheet->getDefaultStyle()->applyFromArray(array(
			  'font'  => array(
				  'size'  => 10,
			  )
		  ));
  
		  $alphabet = range('A', 'Z');
		  $alphabet[] = 'AA';
		  $alphabet[] = 'AB';
		  $alphabet[] = 'AC';
  
		  $spreadsheet->setActiveSheetIndex(0)->setCellValue("A1", 'No');
		  $spreadsheet->setActiveSheetIndex(0)->setCellValue("B1", 'Tanggal Pemeriksaan');
		  $spreadsheet->setActiveSheetIndex(0)->setCellValue("C1", 'Nama Ibu Hamil');
		  $spreadsheet->setActiveSheetIndex(0)->setCellValue("D1", 'Keterangan');

		  $rownum = 2;
		  foreach ($rows as $row) {
			  foreach ($colnames as $index => $colname) {
				  $spreadsheet->setActiveSheetIndex(0)
					  ->setCellValue("{$alphabet[$index]}{$rownum}", $row[$colname]);
			  }
			  $rownum++;
		  }
  
		  // Redirect output to a client’s web browser (Xlsx)
		  header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
		  header('Content-Disposition: attachment;filename="Sikembang.xlsx"');
		  header('Cache-Control: max-age=0');
		  // If you're serving to IE 9, then the following may be needed
		  header('Cache-Control: max-age=1');
  
		  // If you're serving to IE over SSL, then the following may be needed
		  header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
		  header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
		  header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
		  header('Pragma: public'); // HTTP/1.0
  
		  $writer = IOFactory::createWriter($spreadsheet, 'Xlsx');
		  $writer->save('php://output');
		  exit;
	  }

}
