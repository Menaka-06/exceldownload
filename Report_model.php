<?php
class Report_model extends CI_Model{

	public function __construct(){
		parent::__construct();
	}
	public function getStockReport($limit,$start,$date,$stockist){
		$this->db->select('OS.*,CUS.*,OSI.*,CUST.*')->from('tbl_opening_stock as OS');
		$this->db->join('tbl_customers as CUS','CUS.CustomerType=OS.group');
		$this->db->join('tbl_opening_stock_items as OSI','OS.group=OSI.productId');
		
		$this->db->join('tbl_customer_type as CUST','OS.location=CUST.id');
		if(!empty($date)){
			$this->db->where('OS.createdAt >=',$date);
		}
		if(!empty($stockist)){
			$this->db->where('CUS.id',$stockist);
		}
		$this->db->limit($limit,$start);
        $this->db->order_by('OS.id','desc');
        $res=$this->db->get()->result();
		return $res;
		 
	}
	public function stockReportExcelDownload($date,$stockist){
		$this->db->select('OS.*,OSI.*,CUST.*,CUS.*')->from('tbl_opening_stock as OS');
		$this->db->join('tbl_opening_stock_items as OSI','OS.group=OSI.productId');
		$this->db->join('tbl_customer_type as CUST','OS.location=CUST.id');
		$this->db->join('tbl_customers as CUS','CUS.CustomerType=OS.group');
		if(!empty($date)){
			$this->db->where('OS.createdAt >=',$date);
		}
		
		if(!empty($stockist)){
			$this->db->where('CUS.id',$stockist);
		}
        $this->db->order_by('OS.id','desc');
        $res=$this->db->get()->result();
		return $res;
	}
	public function getBranchProductBalanceBetDate($customer_id,$product_id,$date){
		$balance=0;
		$resp=$this->db->select('branchBalance')->where('CreatedAt <=',date('Y-m-d h:i:s',strtotime($date.' 11:59:59')))->where(array('productId'=>$product_id,'CustomerId'=>$customer_id))->order_by('id','desc')->get('tbl_inventory')->row();
		if(!empty($resp)){ $balance=$resp->branchBalance;}
		return $balance;
	}

	public function salesInvoiceExcelDownload($from_date,$to_date,$stockist){
		$this->db->select('SI.*,SID.totalNetAmount,SID.totalBv,SID.productCount,SID.totalMRPAmount,SID.totalGrossAmount,SID.totalDiscountAmount,SID.totalTaxAmount')->from('tbl_sale_invoice as SI');
        $this->db->join('tbl_sale_invoice_details as SID','SI.id=SID.saleInvoiceId');
		if(!empty($from_date)){
			$this->db->where('SI.invoiceDate >=',$from_date);
		}
		if(!empty($to_date)){
			$this->db->where('SI.invoiceDate <=',$to_date);
		}
		if(!empty($stockist)){
			$this->db->where('SI.stockistId',$stockist);
		}
        $this->db->order_by('SI.id','desc');
        $res=$this->db->get()->result();
		return $res;
	}
	public function getSaleInvoiceListReport($limit,$start,$from_date,$to_date,$stockist){
		$this->db->select('SI.*,SID.totalNetAmount,SID.totalBv,SID.productCount,SID.totalMRPAmount,SID.totalGrossAmount,SID.totalDiscountAmount,SID.totalTaxAmount')->from('tbl_sale_invoice as SI');
        $this->db->join('tbl_sale_invoice_details as SID','SI.id=SID.saleInvoiceId');
		if(!empty($from_date)){
			$this->db->where('SI.invoiceDate >=',$from_date);
		}
		if(!empty($to_date)){
			$this->db->where('SI.invoiceDate <=',$to_date);
		}
		if(!empty($stockist)){
			$this->db->where('SI.stockistId',$stockist);
		}
		$this->db->limit($limit,$start);
        $this->db->order_by('SI.id','desc');
        $res=$this->db->get()->result();
		return $res;
	}
}
