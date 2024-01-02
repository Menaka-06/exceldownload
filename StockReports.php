<div class="container-fluid">
    <!-- start page title -->
    <?php $method=""; $method=$this->router->fetch_method();?>
    <div class="row">
        <div class="col-12">
            <div class="page-title-box d-sm-flex align-items-center justify-content-between">
                <h4 class="mb-sm-0"><?php echo $page_name;?></h4>

                <div class="page-title-right ">
                    <!-- <a href="<?php echo base_url()?>vendor_products/listvendor_products"
                        class="btn btn-dark mr-3 btn-gradient waves-effect waves-light"><i
                            class="ri-arrow-left-fill"></i> Back</a> -->
                </div>

            </div>
        </div>
    </div>
    <!-- end page title -->
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1">Stock Report</h4>
                    <div class="flex-shrink-0 d-none">
                    </div>
                </div>
                
                <div class="card-body">
                    <div class="live-preview">
                        <form action="<?php echo base_url();?>Reports/generateStockReports" method="post">
                        <div class="row gy-4">
                             <div class="col-xxl-2 col-md-3">
                                <div>
                                    <label for="date" class="form-label ">Closing Stock Till</label>
                                    <input type="date" class="form-control" id="date"  name="date" required>
                                    <span class="text-danger small" id="date_error"></span>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-md-3">
                                <div>
                                    <label for="stockist" class="form-label">Stockist</label>
                                <select class="form-control" name="stockist" id="stockist">
                                    <option value="">Select Stockist</option>
                                    <?php if(!empty($stockist)){ foreach($stockist as $stk){?>
                                        <option value="<?php echo $stk->id;?>" <?php if(isset($ssstockist)){ if($ssstockist==$stk->id){ echo 'selected';}}?>><?php echo $stk->CustomerName;?>-<?php echo $stk->CustomerCode;?></option>
                                        <?php } } ?>
                                    
                                </select>
                                <span class="text-danger small" id="stockist_error"></span>
                                    
                                </select>
                                    <span class="text-danger small" id="date_error"></span>
                                </div>
                            </div>
                            <div class="col-xxl-2 col-md-2">
                                <div class= "mt-4">
                                    <label for="category_name" class="form-label mt-3"></label>
                                    <button type="submit" class="btn btn-success btn-sm mt-2" name="search_stock_report">Download Stock Report</button>
                                </div>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <?php if($method=='generateStockReports'){ ?>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header align-items-center d-flex">
                    <h4 class="card-title mb-0 flex-grow-1"><?php echo $page_name;?> Details</h4>
                    <div class="flex-shrink-0">
                    <form action="<?php echo base_url();?>Reports/downloadExcelStockReport" method="post">
                    <input type="hidden"  name="search_date" value="<?php if(isset($date)){ echo $date; } ?>">
                    
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

                                    <th scope="col">Stock Code</th>
                                    <th scope="col">Location </th>
                                    <th scope="col">Stockist </th>
                                    <th scope="col">Control Number</th>
                                    <th scope="col">Batch Number</th>
                                    <th scope="col">Expiry Date</th>
                                    <th scope="col">Quantity</th>
                                    
                                </tr>
                            </thead>
                            <tbody>
                                <?php if(!empty($openingstock_details)){ foreach($openingstock_details as $OSD){?>
                                    <tr>
                                        <td><?php if(!empty($OSD->openingStockCode)){ echo $OSD->openingStockCode; }?></td>
                                       
                                        <td><?php if(!empty($OSD->customerType)){ echo $OSD->customerType; }?></td>
                                        <td><?php if(!empty($OSD->customerName)){ echo $OSD->customerName; }?></td>
                                                                            
                                        <td><?php if(!empty($OSD->controlNo)){ echo $OSD->controlNo; }?></td>
                                        <td><?php if(!empty($OSD->batchNo)){ echo $OSD->batchNo; }?></td>
                                        <td><?php if(!empty($OSD->expiryDate)){ echo $OSD->expiryDate; }?></td>
                                        <td><?php if(!empty($OSD->quantity)){ echo $OSD->quantity; }?></td>

                                        
                                    </tr>
                                    <?php } }else{ ?>
                                        <tr>
                                            <td colspan="17" align="center">No Records Found</td>
                                        
                                     <td >
                                         
                                         <div class="page-title-right ">
                            <a href="<?php echo base_url();?>Reports/StockReports" class="btn btn-dark btn-sm bg-gradient waves-effect waves-light text-uppercase"> <i data-feather="arrow-left"></i> Back</a>
                        </div></td></tr>
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
