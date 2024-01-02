<?php

class Reports extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->common_model->check_login();
        $this->load->model('report_model');
        
    }

    public function customerWiseReports(){
        $data['page_name']='Customer Wise Reports';
		$data['sub_page']='Reports/CustomerWiseReports';
		$this->load->view('user_index',$data);
    }
    public function alloyWiseReports(){
        $data['page_name']='Alloy Wise Reports';
		$data['sub_page']='Reports/AlloyWiseReports';
		$this->load->view('user_index',$data);
    }
    public function itemWiseReports(){
        $data['page_name']='Item Wise Reports';
		$data['sub_page']='Reports/ItemWiseReports';
		$this->load->view('user_index',$data);
    }
    public function stockReports(){
        $data['page_name']='Stock Wise Reports';
        $data['sub_page']='reports/stockReports';
        $config['base_url'] = base_url()."reports/stockReports"; 
        
        $data['stockist']=$this->common_model->getActiveCustomer();
        $this->load->view('user_index',$data);
    }
     public function generateStockReports(){
      $date=$this->security->xss_clean($this->input->post('date'));
      $stockist=$this->security->xss_clean($this->input->post('stockist'));
      if(empty($date) | empty($stockist)){
            $this->session->set_flashdata('warning', 'Some fields are empty');
            redirect(base_url().'reports/stockReports');
        }
        $config['base_url'] = base_url()."reports/stockReports"; 
        $config['total_rows'] = $this->common_model->getTotalRecords('tbl_opening_stock',array());
        $config['per_page'] = PAGINATION_COUNT; 
        $config=$this->common_model->paginationStyle($config);
        $this->pagination->initialize($config); 
        $lmt=0;
        $lmt=$this->uri->segment(3);
        //$lmt=mysqli_real_escape_string($this->db->conn_id,$lmt);
        $data['openingstock_details']=$this->report_model->getStockReport($config['per_page'],$lmt,$date,$stockist);
        $data['page_name']='Stock Report Details';
        $data['sub_page']='reports/stockReports';
        $data['customer']=$this->common_model->getActiveCustomer();
        $data['date']=$date;
        $data['stockist']=$stockist;
        $this->load->view('user_index',$data);
    }
    public function downloadExcelStockReport(){
        $date=$this->security->xss_clean($this->input->post('search_date'));
        $stockist=$this->security->xss_clean($this->input->post('search_stockist_id'));
        if(empty($date) | empty($stockist)){
            $this->session->set_flashdata('warning', 'Some fields are empty');
            redirect(base_url().'reports/stockReports');
        }
        $stockReportlist=$this->report_model->stockReportExcelDownload($date,$stockist);
        if(empty($stockReportlist)){
            $this->session->set_flashdata('warning','No data To Display');
            redirect(base_url().'reports/stockReports');
        }
        if(!empty($stockReportlist)){
            foreach($stockReportlist as $SRL){
              
                $perBV['Stock Code']=$SRL->openingStockCode;
                $perBV['Location']=$SRL->customerType;
                $perBV['Stockist']=$SRL->customerName;
                $perBV['Control Number']=$SRL->controlNo;
                $perBV['Batch Number']=$SRL->batchNo;
                $perBV['Expiry Date']=$SRL->expiryDate;
                $perBV['Quantity']=$SRL->quantity;
                
                $per_ata[]=$perBV;
                
            }
            $data=$per_ata;
            $filename=$date.'-'.$stockist."stock-wise-report";
            $export=$this->common_model->ExcelExport($filename,$data);
        }
    }

    public function salesInvoiceReport(){
        $data['page_name']='Sales Invoice Reports';
        $data['sub_page']='reports/salesInvoiceReport';
        $config['base_url'] = base_url()."reports/salesInvoiceReport"; 
        $data['customer']=$this->common_model->getActiveCustomer();
        $this->load->view('user_index',$data);
    }
    public function generateInvoiceReport(){
        $date=$this->security->xss_clean($this->input->post('date'));
        $to_date=$this->security->xss_clean($this->input->post('to_date'));
        $stockist=$this->security->xss_clean($this->input->post('stockist'));
        if(empty($date) | empty($to_date) | empty($stockist)){
            $this->session->set_flashdata('warning', 'Some fields are empty');
            redirect(base_url().'reports/salesInvoiceReport');
        }
        $config['base_url'] = base_url()."reports/salesInvoiceReport"; 
        $config['total_rows'] = $this->common_model->getTotalRecords('tbl_sale_invoice',array());
        $config['per_page'] = PAGINATION_COUNT; 
        $config=$this->common_model->paginationStyle($config);
        $this->pagination->initialize($config); 
        $lmt=0;
        $lmt=$this->uri->segment(3);
        $lmt=mysqli_real_escape_string($this->db->conn_id,$lmt);
        $data['invoice_details']=$this->report_model->getSaleInvoiceListReport($config['per_page'],$lmt,$date,$to_date,$stockist);
        $data['page_name']='Sales Invoice report';
        $data['sub_page']='reports/salesInvoiceReport';
        $data['customer']=$this->common_model->getActiveCustomer();
        $data['from_date']=$date;
        $data['to_date']=$to_date;
        $data['stockist']=$stockist;
        $this->load->view('user_index',$data);
    }
    public function downloadExcelSalesInvoice(){
        $date=$this->security->xss_clean($this->input->post('search_from_date'));
        $to_date=$this->security->xss_clean($this->input->post('search_to_date'));
        $stockist=$this->security->xss_clean($this->input->post('search_stockist_id'));
        if(empty($date) | empty($to_date) | empty($stockist)){
            $this->session->set_flashdata('warning', 'Some fields are empty');
            redirect(base_url().'reports/salesInvoiceReport');
        }
        $saleInvoiceList=$this->report_model->salesInvoiceExcelDownload($date,$to_date,$stockist);
        if(empty($saleInvoiceList)){
            $this->session->set_flashdata('warning','No data To Display');
            redirect(base_url().'reports/salesInvoiceReport');
        }
        if(!empty($saleInvoiceList)){
            foreach($saleInvoiceList as $INV){
                $perBV['Sales Invoice Date']=date('d-m-Y',strtotime($INV->invoiceDate));
                $perBV['Sales Invoice Number']=$INV->invoiceNum;
                $perBV['Direct Seller ID']=$INV->distributerId;
                $perBV['Direct Seller Name']=$INV->distributerName;
                $perBV['Invoice Type']=$INV->invoiceType;
                $perBV['Bonus Month']=$INV->bonusMonth;
                $perBV['Stockist Name']=$INV->stockistName;
                $perBV['Stockist Code']=$INV->stockistCode;
                $perBV['Tax Type']=$INV->taxType;
                $perBV['Product Count']=$INV->productCount;
                $perBV['Total MRP Amount']=$INV->totalMRPAmount;
                $perBV['Total BV']=$INV->totalBv;
                $perBV['Total Gross Amount']=$INV->totalGrossAmount;
                $perBV['Total Discount Amount']=$INV->totalDiscountAmount;
                $perBV['Total Tax Amount']=$INV->totalTaxAmount;
                $perBV['Total Net Amount']=$INV->totalNetAmount;
                $perBV['Created Date']=date('d-m-Y h:i:s',strtotime($INV->createdAt));

                $per_ata[]=$perBV;
                
            }
            $data=$per_ata;
            $filename=$date.'-'.$to_date.'-'.$stockist."sales-invoice-report";
            $export=$this->common_model->ExcelExport($filename,$data);
        }
    }

 }
