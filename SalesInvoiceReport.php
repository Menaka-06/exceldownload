<div class="container-fluid">
    <!-- start page title -->
    
<?php $method=""; $method=$this->router->fetch_method();?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><?php echo $page_name;?></h4>
                    <div class="flex-shrink-0 d-none">
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="live-preview">
                        <form action="<?php echo base_url();?>Reports/generateInvoiceReport" method="post">
                        <div class="row gy-4">
                            <div class="col-xxl-2 col-md-3">
                                <div>
                                    <label for="date" class="form-label ">From Date</label>
                                    <input type="date" class="form-control" id="date"  value="<?php if(isset($from_date)){echo date('Y-m-d',strtotime($from_date));}else{ echo date('Y-m-01'); }?>"  name="date" required>
                                    <span class="text-danger small" id="date_error"></span>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-md-3">
                                <div>
                                    <label for="to_date" class="form-label ">To Date</label>
                                    <input type="date" class="form-control" id="to_date"  name="to_date" value="<?php if(isset($to_date)){echo date('Y-m-d',strtotime($to_date));}else{ echo date('Y-m-d'); }?>" required>
                                    <span class="text-danger small" id="to_date_error"></span>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-md-3">
                                <div>
                                    <label for="date" class="form-label ">Stockist</label>
                                    <select class="form-control" name="stockist" id="stockist" required>
                                        <option value="">--Select Stockist--</option>
                                        <?php if(!empty($customer)){  foreach($customer as $cus){?>
                                            <option value="<?php echo $cus->id; ?>" <?php if(isset($stockist)){ if($cus->id==$stockist){ echo 'selected';}}?>><?php echo $cus->CustomerName; ?>-<?php echo $cus->CustomerCode; ?></option>
                                            <?php } }?>
                                    </select>
                                    <span class="text-danger small" id="date_error"></span>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-md-2">
                                <div class= "mt-4">
                                    <label for="category_name" class="form-label mt-3"></label>
                                    <button type="submit" class="btn btn-success btn-sm mt-2" name="sales_invoice_report">Search Report</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>                             
    
    <?php if($method=='generateInvoiceReport'){ ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><?php echo $page_name;?> Details</h4>
                    <div class="flex-shrink-0">
                    <form action="<?php echo base_url();?>Reports/downloadExcelSalesInvoice" method="post">
                    <input type="hidden"  name="search_from_date" value="<?php if(isset($from_date)){ echo $from_date; } ?>">
                    <input type="hidden"  name="search_to_date" value="<?php if(isset($to_date)){ echo $to_date; } ?>">
                    <input type="hidden"  name="search_stockist_id" value="<?php if(isset($stockist)){ echo $stockist; } ?>">
                        <button type="submit" class="btn btn-success waves-effect waves-light"> <i data-feather="download-cloud"></i>&nbsp;&nbsp;Download Excel</button>
                    </form>
                    </div>
                </div><!-- end card header -->

                <div class="card-body">
                    <div class="live-preview">
                        <div class="row">
                            <div class="col-xl-12">
                                <div class="table-responsive">
                                <table class="table table-nowrap mb-0">
                            <thead class="table-light">
                                <tr>

                                    <th scope="col">Sales Invoice Date</th>
                                    <th scope="col">Sales Invoice Number</th>
                                    <th scope="col">Direct Seller ID </th>
                                    <th scope="col">Direct Seller Name</th>
                                    <th scope="col">Invoice Type</th>
                                    <th scope="col">Bonus Month</th>
                                    <th scope="col">Stockist Name</th>
                                    <th scope="col">Stockist Code</th>
                                    <th scope="col">Tax Type</th>
                                    <th scope="col">Product Count</th>
                                    <th scope="col">Total MRP Amount</th>
                                    <th scope="col">Total BV</th>
                                    <th scope="col">Total Gross Amount</th>
                                    <th scope="col">Total Discount Amount</th>
                                    <th scope="col">Total Tax Amount</th>
                                    <th scope="col">Total Net Amount</th>
                                    <th scope="col">Created Date</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($invoice_details)){ foreach($invoice_details as $INV){?>
                                    <tr>
                                        <td><?php if(!empty($INV->invoiceDate)){ echo date('d-m-Y',strtotime($INV->invoiceDate)); }?></td>
                                        <td><?php if(!empty($INV->invoiceNum)){ echo $INV->invoiceNum; }?></td>
                                        <td><?php if(!empty($INV->distributerId)){ echo $INV->distributerId; }?></td>
                                        <td><?php if(!empty($INV->distributerName)){ echo $INV->distributerName; }?></td>
                                        <td><?php if(!empty($INV->invoiceType)){ echo $INV->invoiceType; }?></td>
                                        <td><?php if(!empty($INV->bonusMonth)){ echo $INV->bonusMonth; }?></td>
                                        <td><?php if(!empty($INV->stockistName)){ echo $INV->stockistName; }?></td>
                                        <td><?php if(!empty($INV->stockistCode)){ echo $INV->stockistCode; }?></td>
                                        <td><?php if(!empty($INV->taxType)){ echo $INV->taxType; }?></td>
                                        <td><?php if(!empty($INV->productCount)){ echo $INV->productCount; }?></td>
                                        <td><?php if(!empty($INV->totalMRPAmount)){ echo $INV->totalMRPAmount; }?></td>
                                        <td><?php if(!empty($INV->totalBv)){ echo $INV->totalBv; }?></td>
                                        <td><?php if(!empty($INV->totalGrossAmount)){ echo $INV->totalGrossAmount; }?></td>
                                        <td><?php if(!empty($INV->totalDiscountAmount)){ echo $INV->totalDiscountAmount; }?></td>
                                        <td><?php if(!empty($INV->totalTaxAmount)){ echo $INV->totalTaxAmount; }?></td>
                                        <td><?php if(!empty($INV->totalNetAmount)){ echo $INV->totalNetAmount; }?></td>
                                        <td><?php if(!empty($INV->createdAt)){ echo date('d-m-Y h:i:s',strtotime($INV->createdAt)); }?></td>
                                    </tr>
                                    <?php } }else{ ?>
                                        <tr>
                                            <td colspan="17" align="center">No Records Found</td>
                                        </tr>
                                    <?php } ?>
                            </tbody>
                        </table>
                                    
                                    <nav class="mt-3 d-block">
                                        <?php echo $this->pagination->create_links(); ?>
                                    </nav>
                                </div>
                            </div>
                            <!--end col-->

                        </div>
                        <!--end row-->
                    </div>
                    
                </div><!-- end card-body -->
            </div><!-- end card -->
        </div>
        <!-- end col -->
    </div>
    <?php } ?>
</div>
<!-- container-fluid -->