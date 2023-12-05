$(document).ready(function () {
    var DOMAIN = "http://localhost/inventory_system/public_html";
    adddNewRow();
    
    $("#add").click(function () {
        adddNewRow();

    })
    

    function adddNewRow()
    {
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method:"POST",
            data: { getNewOrderItem: 1 },
            success: function (data) {
                $("#invoice_item").append(data);
                var n = 0;
                $(".number").each(function () {
                    $(this).html(++n);
                })
            }
        })
    }

    $("#remove").click(function () {
        $("#invoice_item").children("tr:last").remove();
        calculate(0, 0);
    })

    $("#invoice_item").delegate(".pid", "change", function () {
        var pid = $(this).val();
        var tr = $(this).parent().parent();
        $(".overlay").show();
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            dataType:"json",
            data: { getPriceAndQty: 1, id: pid },
            success: function (data) {
                // console.log(data);
                tr.find(".tqty").val(data["prodect_stock"]);
                tr.find(".qty").val(1);
                tr.find(".pro_name").val(data["prodect_name"])
                tr.find(".price").val(data["prodect_price"]);
                tr.find(".amt").html(tr.find(".qty").val() * tr.find(".price").val());
                calculate(0,0);

            }
        })

    })
    $("#invoice_item").delegate(".qty", "keyup", function () {
        var qty = $(this);
        var tr = $(this).parent().parent();
        if (isNaN(qty.val())) {
            alert("Please enter a valid quantity..");
            qty.val(1);
        }
        else {
            if ((qty.val() -0) > (tr.find(".tqty").val()-0)) {
                alert("Sorry! This much of quantity is not available");
                qty.val(1);
            }
            else {
                tr.find(".amt").html(qty.val() * tr.find(".price").val());
                calculate(0,0);
            }
        }
    })
    function calculate(dis,paid)
    {
        var sub_total = 0;
        var gst = 0;
        var discount = dis;
        var paid_amt = paid;
        var due = 0;
        var net_total = 0;
        $(".amt").each(function () {
            sub_total = sub_total + ($(this).html() * 1);
        })
        gst = 0.18 * sub_total;
        net_total = gst + sub_total;
        net_total = net_total - discount;
        due = net_total - paid_amt;
        $("#sub_total").val(sub_total);
        $("#gst").val(gst);
        $("#discount").val(discount);
        $("#net_total").val(net_total);
        $("#due").val(due);

        
    }
    $("#discount").keyup(function () {
        var discount = $(this).val();
        calculate(discount,0);
    })
    $("#paid").keyup(function () {
        var paid = $(this).val();
        var discount = $("#discount").val();
        calculate(discount, paid);
    })

    /////order acception//////
    $("#order_form").click(function () {
        var qty = $(".qty");
        var tr = $(".qty").parent().parent();
        var invoice = $("#get_order_data").serialize();

        if ($("#customer_name").val() == "" || $("#paid").val() == "") {
            alert("Fill All required data");
        }
        else if ((qty.val() - 0) > (tr.find(".tqty").val() - 0)) {
            alert("Sorry! This much of quantity is not available");
            qty.val(1);
        }      
        
        else {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#get_order_data").serialize(),
                success: function (data) {
                    if (data == "ORDER_COMPLETED") {
                        $("#get_order_data").trigger("reset");
                        alert("Succrssfully ordered");
                    }
                    else {
                        alert("Erorr");
                    }
                  
                }
            })
        }
    })
})