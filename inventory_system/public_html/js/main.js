
$(document).ready(function () {
    var DOMAIN = "http://localhost/inventory_system/public_html";
    $("#register_form").on("submit", function () {
         var status = false;
         var name = $("#username");
         var email = $("#email");
         var pass1 = $("#password1");
         var pass2 = $("#password2");
         var type = $("#usertype");
         var n_patt = new RegExp(/^[A-Za-z ]+$/);
         var e_patt = new RegExp(/^[a-z0-9_-]+(\.[a-z0-9_-]+)*@[a-z0-9_-]+(\.[a-z0-9_-]+)*(\.[a-z]{2,4})$/);
         if (name.val() == "") {
             name.addClass("border-danger");
             $("#ur_error").html("<span class='text-danger'>Please enter Name</span>");
             status = false;           
         }
         else {
             name.removeClass("border-danger");
             $("#ur_error").html("");
             status = true;
        }
        if (!e_patt.test(email.val())) {
             email.addClass("border-danger");
             $("#e_error").html("<span class='text-danger'>Please enter Valid Email</span>");
             status = false;           
         }
         else {
             email.removeClass("border-danger");
             $("#e_error").html("");
             status = true;
        }
        if (pass1 == "" ||pass1.val().length<9) {
             pass1.addClass("border-danger");
             $("#p1_error").html("<span class='text-danger'>Please enter more than 9 char Password</span>");
             status = false;           
         }
         else {
             pass1.removeClass("border-danger");
             $("#p1_error").html("");
             status = true;
        }
           if (pass2 == "" ||pass2.val().length<9) {
             pass2.addClass("border-danger");
             $("#p2_error").html("<span class='text-danger'>Please enter more than 9 char Password</span>");
             status = false;           
         }
         else {
             pass2.removeClass("border-danger");
             $("#p2_error").html("");
             status = true;
        }
          if (type.val()=="") {
             type.addClass("border-danger");
             $("#type_error").html("<span class='text-danger'>Please enter Type</span>");
             status = false;           
         }
         else {
             type.removeClass("border-danger");
             $("#type_error").html("");
             status = true;
        }
        if (pass1.val() == pass2.val() && status == true) {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#register_form").serialize(),
                success: function (data) {
                    if (data == "email_already_exists") {
                       alert("your Email is already used");
                    }
                    else if(data=="some_error") {
                        alert("Something Wrong");
                    }
                    else {
                        
                        window.location.href = encodeURI(DOMAIN + "/index.php?msg=you are registerd now you can login");
                    }
                }
            })
        }
        else {
             
             pass2.addClass("border-danger");
             $("#p2_error").html("<span class='text-danger'>Passwords are not matched</span>");
             status = false; 
        }
    })
    //for log in part:
    $("#login_form").on("submit", function () {
        var email = $("#log_email");
        var pass = $("#log_pass");
        var status = false;
        if (email.val() == "") {
            email.addClass("border-danger");
            $("#e_error").html("<span class='text-danger'>Please enter email Address</span>");
            status = false;
        }
        else {
            email.removeClass("border-danger");
            $("#e_error").html("");
            status = true;
        }

          if (pass.val() == "") {
            pass.addClass("border-danger");
            $("#p_error").html("<span class='text-danger'>Please enter Password</span>");
            status = false;
        }
        else {
            pass.removeClass("border-danger");
            $("#p_error").html("");
            status = true;
        }
        if (status) {
            $.ajax({
                url:DOMAIN + "/includes/process.php",
                method:"POST",
                data:$("#login_form").serialize(),
                success: function (data)
                {
                        if (data == "Not_Registerd") {
                            $("#e_error").html("<span class='text-danger'>You are not registerd</span>");
                        }
                        else if(data == "password_not_matched"){
                            $("#p_error").html("<span class='text-danger'>Please enter correct Password</span>");

                    }
                        else {
                            console.log(data);
                            window.location.href = DOMAIN + "/dashboard.php";
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
                var choose = "<option value='0'>Choose Category</option>";
                $("#parent_cat").html(root + data);
                $("#select_cat").html(choose + data);
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
                $("#select_brand").html(choose + data);
            }
        })
    }
    //Add category
    $("#category_form").on("submit", function () {
        if ($("#cat_name").val() == "") {
            $("#cat_name").addClass("border-danger");
            $("#cat_error").html("<span>Please enter the category name</span>");
        }
        else {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#category_form").serialize(),
                success: function (data) {
                    if (data == "CATEGORY_ADDED") {
                        $("#cat_name").removeClass("border-danger");
                        $("#cat_error").html("<span class='text-success'>New Category Added sucessfully</span>");
                        $("#cat_name").val("");
                        fetch_category();
                    }
                    else {
                        alert(data);
                    }
                }
            })
        }
    })

    //Add brand
    $("#brand_form").on("submit", function () {
        if ($("#brand_name").val() == "") {
            $("#brand_name").addClass("border-danger");
            $("#brand_error").html("<span class='text-danger'>Enter Brand name</span>");
        }
        else {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#brand_form").serialize(),
                success: function (data) {
                    if (data == "Brand_ADDED") {
                        $("#brand_name").removeClass("border-danger");
                        $("#brand_error").html("<span class='text-success'>New Brand AddedSuccessfuly</span>");
                        $("#brand_name").val("");
                        fetch_brand();
                    } else {
                        alert(data);
                    }
                
                }
            })
            
        }
    })
    //Add prodect 
    $("#prodect_form").on("submit", function () {

        if ($("#p_name").val() == "") {
            $("#p_name").addClass("border-danger");
            $("#prodect_error").html("<span class='text-danger'>Enter Prodect name</span>");
        }
        else {
            $.ajax({
                url: DOMAIN + "/includes/process.php",
                method: "POST",
                data: $("#prodect_form").serialize(),
                success: function (data) {
                    if (data == "PRODECT_ADDED") {
                        $("#p_name").removeClass("border-danger");
                        $("#prodect_error").html("<span class='text-success'></span>");
                        $("#p_name").val("");
                        alert(data);
                    } else {
                        alert(data);
                    }
                
                }
            })
        }
        
    })
   
    
})
