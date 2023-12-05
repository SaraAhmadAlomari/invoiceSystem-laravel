<?php
include_once("./database/constants.php");
if(!isset($_SESSION["userid"])){
  header("location:".DOMAIN."/");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inventory Managment System</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.min.js" integrity="sha384-+sLIOodYLS7CIrQpBjl+C7nPvqq+FbNUBDunl/OZv93DB7Ln/533i8e/mZXLi/P+" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
    <script src="./js/order.js"></script>
</head>
<body>
    <div class="overlay"> <div class="loader"></div></div>
       <!-- Navbar -->
  <?php include_once("./templets/header.php");?>

  <div class="container mt-5">

  <div class="row">
    <div class="col-md-10  mx-auto">
    <div class="card" style="box-shadow:0 0 10px 0 lightgray;">
        <div class="card-header">
          <h4> New Orders</h4>
        </div>
        <div class="card-body">
            <form onsubmit="return false" id="get_order_data">
                <div class="form-group row">
                    <label class="col-sm-3 col-form-lable" align="right">Order Date</label>
                    <div class="col-sm-6">
                        <input type="text" id="order_date" name="order_date" class="form-control form-control-sm"value="<?php echo date("Y-m-d"); ?>" readonly>
                    </div>
                </div>

                <div class="form-group row">
                    <label class="col-sm-3 col-form-lable" align="right">Customer Name</label>
                    <div class="col-sm-6">
                        <input type="text"id="customer_name" name="customer_name" class="form-control form-control-sm" placeholder="Enter Customer Name" required>
                        <small id="c_error" class="form-text text-muted"></small>

                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <h3 style="text-align:center">Make A Order List</h3>
                        <table style="width:100%;  margin:10px 10px 10px 0; align:center;">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th style="text-align:center">Item Name</th>
                                    <th style="text-align:center">Total Quantity</th>
                                    <th style="text-align:center">Quantity</th>
                                    <th style="text-align:center">Price</th>
                                    <th>Total</th>
                                </tr>
                            </thead>
                            <tbody id="invoice_item">
                                <!-- <tr>
                                    <td id="number">1</td>
                                    <td>
                                        <select name="pid[]" class="form-control form-control-sm">
                                            <option value="">Washing Machine</option>
                                        </select>
                                    </td>    
                                    <td><input type="text" name="tqty[]"readonly class="form-control form-control-sm"></td>
                                    <td><input type="text" name="qty[]" class="form-control form-control-sm" required></td>                            
                                    <td><input type="text" name="price[]"readonly class="form-control form-control-sm"></td>   
                                    <td >JD.1540</td>                         
                                </tr> -->
                            </tbody>
                        </table>
                        <center>
                            <button style="width:150px;" id="add" class="btn btn-success">Add</button>
                            <button style="width:150px;" id="remove" class="btn btn-danger">Remove</button>
                        </center>
                    </div>
                </div>
                <p></p>
                <div class="form-group row">
                    <label for="sub_total"class="col-sm-3 col-form-lable" align="right">Sub Total</label>
                    <div class="col-sm-6">
                        <input type="text" name="sub_total" id="sub_total" class="form-control form-control-sm" required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="gst"class="col-sm-3 col-form-lable" align="right">GST(18%)</label>
                    <div class="col-sm-6">
                        <input type="text" name="gst" id="gst" class="form-control form-control-sm" required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="discount"class="col-sm-3 col-form-lable" align="right">Discount</label>
                    <div class="col-sm-6">
                        <input type="text" name="discount" id="discount" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="net_total"class="col-sm-3 col-form-lable" align="right">Net Total</label>
                    <div class="col-sm-6">
                        <input type="text" name="net_total" id="net_total" class="form-control form-control-sm" required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="paid"class="col-sm-3 col-form-lable" align="right">Paid</label>
                    <div class="col-sm-6">
                        <input type="text" name="paid" id="paid" class="form-control form-control-sm" required>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="due"class="col-sm-3 col-form-lable" align="right">Due</label>
                    <div class="col-sm-6">
                        <input type="text" name="due" id="due" class="form-control form-control-sm" required readonly>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="payment_type"class="col-sm-3 col-form-lable" align="right">Payment Method</label>
                    <div class="col-sm-6">
                        <select name="payment_type" id="payment_type" class="form-control form-control-sm" required>
                            <option value="Cash">Cash</option>
                            <option value="Card">Card</option>
                            <option value="Draft">Draft</option>
                            <option value="Cheque">Cheque</option>
                        </select>
                    </div>
                </div>
                <center>
                    <input type="submit" id="order_form" style="width:150px;" class="btn btn-info" value="Order">
                    <input type="submit" id="print_invoice" style="width:150px;" class="btn btn-success d-done" value="Print Invoice">
                </center>
            </form>
        </div>
    </div>
    </div>
  </div>
  </div>

</body>
</html> 
