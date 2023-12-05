
$(document).ready(function () {
    var DOMAIN = "http://localhost/inventory_system/public_html";
    //manage category
    manageCategory(1);
    function manageCategory(pn) {
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: { manageCategory: 1,pageno:pn },
            success: function (data) {
                $("#get_category").html(data);
            }
            
        })
        
    }

       //manage brand
    manageBrand(1);
    function manageBrand(pn) {
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: { manageBrand: 1,pageno:pn },
            success: function (data) {
                $("#get_brand").html(data);
            }
            
        })
        
    }

     //manage prodect
    manageProdect(1);
    function manageProdect(pn) {
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: { manageProdect: 1,pageno:pn },
            success: function (data) {
                $("#get_prodect").html(data);
            }
            
        })
        
    }

    //pagination category
    $("body").delegate(".page-link", "click", function () {
        var pn = $(this).attr("pn");
        manageCategory(pn);
    })

     //pagination brand
    $("body").delegate(".page-link", "click", function () {
        var pn = $(this).attr("pn");
        manageBrand(pn);
    })

     //pagination prodect
    $("body").delegate(".page-link", "click", function () {
        var pn = $(this).attr("pn");
        manageProdect(pn);
    })

    //delete category
    $("body").delegate(".del_cat", "click", function () {
        var delete_id = $(this).attr("delete_id");
        //console.log(delete_id);
        if (confirm("Are you sure ? You want to delete..!"))
        {
              $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: { deleteCategory: 1,id:delete_id },
                  success: function (data) {
                if (data == "DEPENDENT_CATEGORY") {
                    alert("Sorry! This Categorty is dependent on other sub CAtegory");
                }
                else if(data=="CATEGORY_DELETED"){
                    alert("Category Deleted Successfully..");
                     manageCategory(1);
                }
                else if (data == "DELETED") {
                     alert("Deleted Successfully..");
                }
                else {
                    alert(data);
                }
          
            }
            
        })
        }
        else
        {
           
        }
    })

    //delete brand
    $("body").delegate(".del_brand", "click", function () {
        var delete_id = $(this).attr("delete_id");
        //console.log(delete_id);
        if (confirm("Are you sure ? You want to delete..!"))
        {
              $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: { deleteBrand: 1,id:delete_id },
                  success: function (data) {
                 if (data == "DELETED") {
                     alert("Brand is deleted Successfully..");
                     manageBrand(1);
                }
                else {
                    alert(data);
                }
          
            }
            
        })
        }
      
    })

        //delete prodect
    $("body").delegate(".del_prodect", "click", function () {
        var delete_id = $(this).attr("delete_id");
        //console.log(delete_id);
        if (confirm("Are you sure ? You want to delete..!"))
        {
              $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: { deleteProdect: 1,id:delete_id },
                  success: function (data) {
                 if (data == "DELETED") {
                     alert("Prodects is deleted Successfully..");
                     manageProdect(1);
                }
                else {
                    alert(data);
                }
          
            }
            
        })
        }
      
    })
      
    //fetch category
    fetch_category();
    function fetch_category() {
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: {getCategory:1},
            success: function (data) {
                var root = "<option value='0'>Root</option>";
                var choose = "<option value='0'>PChoose Category</option>";
                $("#parent_cat").html(root + data);
                $("#update_prodect_cat").html(choose + data);
            }
        })
    }

      //fetch brand
    fetch_brand();
    function fetch_brand() {
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            data: {getBrand:1},
            success: function (data) {
                var choose = "<option value='0'>Choose Brand</option>";
                $("#update_prodect_brand").html(choose + data);
            }
        })
    }
    // update category
    $("body").delegate(".edit_cat", "click", function () {
        var edit_id = $(this).attr("edit_id");
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            dataType: "Json",
            data: { updateCategory: 1, id: edit_id },
            success: function (data) {
                // alert(data);
                // alert(data["category_name"]);
                $("#cid").val(data["cid"]);
                $("#update_cat").val(data["category_name"]);
                $("#parent_cat").val(data["parent_cat"]);
               
            }
        })
    })
 $("#update_category_form").on("submit", function () {
          if ($("#update_cat").val() == "") {
            $("#update_cat").addClass("border-danger");
            $("#cat_error").html("<span>Please enter the category name</span>");
        }
        else {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#update_category_form").serialize(),
                success: function (data) {
                    alert(data);
                    window.location.href = "";
                }
            })
        } 
 })
    
    // update brand
    $("body").delegate(".edit_brand", "click", function () {
        var edit_id = $(this).attr("edit_id");
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            dataType: "Json",
            data: { updateBrand: 1, id: edit_id },
            success: function (data) {
                // alert(data);
                // alert(data["brand_name"]);
                $("#bid").val(data["bid"]);
                $("#update_brandd").val(data["brand_name"]);               
            }
        })
    })

     $("#update_brand_form").on("submit", function () {
          if ($("#update_brandd").val() == "") {
            $("#update_brandd").addClass("border-danger");
            $("#brand_error").html("<span class=' text-danger'>Please enter the brand name</span>");
        }
        else {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#update_brand_form").serialize(),
                success: function (data) {
                    alert(data);
                    window.location.href = "";
                }
            })
        } 
     })
    
     // update prodect
    $("body").delegate(".edit_prodect", "click", function () {
        var edit_id = $(this).attr("edit_id");
        $.ajax({
            url: DOMAIN + "/includes/process.php",
            method: "POST",
            dataType: "Json",
            data: { updateProdect: 1, id: edit_id },
            success: function (data) {
                // alert(data);
                // alert(data["bid"]);
                // alert(data["cid"]);
                $("#pid").val(data["pid"]);
                $("#update_prodect_name").val(data["prodect_name"]);      
                $("#update_prodect_cat").val(data["cid"]);      
                $("#update_prodect_brand").val(data["bid"]);      
                $("#update_prodect_price").val(data["prodect_price"]);      
                $("#update_prodect_qnty").val(data["prodect_stock"]);      
            }
        })
    })

     $("#update_prodect_form").on("submit", function () {
          if ($("#update_prodect_name").val() == "") {
            $("#update_prodect_name").addClass("border-danger");
            $("#update_prodect_error").html("<span class=' text-danger'>Please enter the brand name</span>");
        }
        else {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#update_prodect_form").serialize(),
                success: function (data) {
                    alert(data);
                    window.location.href = "";
                }
            })
        } 
 })

})