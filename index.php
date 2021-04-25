<!DOCTYPE html>
<html>
 <head>
  <title>Products</title>
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" />
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>
 </head>
 <body>
     <header>
        <h3 style="text-align:center">Products</h3>
     </header>
  <br />
  <div class="container">
  <div class="statusMsg"></div> 
  <br />
   <div class="container">
        <div style="margin: auto; width: 50%">
            <form method="POST" id="addprod" enctype="multipart/form-data">
                    <div class="form-group">
                        <label for="name">Product Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter product name" required />
                    </div>
                    <div class="form-group">
                        <label for="price">Product price</label>
                        <input type="number" class="form-control" id="price" name="price" placeholder="Enter price" required />
                    </div>
                    <div class="form-group">
                        <label for="desc">Product description</label>
                        <textarea class="form-control" id="desc" name="desc" placeholder="Enter product description" rows="4" cols="50"></textarea>
                    </div>
                    <div class="form-group">
                        <input type="file" class="form-control-file" name="multiple_files" id="multiple_files" multiple/>
                        <span class="text-muted">Only jpg, png file allowed</span>
                        <span id="error_multiple_files"></span>
                    </div>
                    
                    <input type="submit" name="submit" class="btn btn-success submitBtn" value="Add Product"/>
                </form>
        </div>
    </div>
    <p id="msg"></p>
   <br />
   <div class="table-responsive" id="products">
    
   </div>
  </div>
 </body>
</html>

<div id="editmodal" class="modal fade" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <form method="POST" id="edit_image_form">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Edit Product Details</h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label>Product Name</label>
                        <input type="text" name="product_name" id="product_name" class="form-control" required/>
                    </div>
                    <div class="form-group">
                        <label>Product Price</label>
                        <input type="number" required name="product_price" id="product_price" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label>Product Description</label>
                        <textarea class="form-control" id="product_description" name="product_description" placeholder="Enter product description" rows="4" cols="50"></textarea>
                    </div>
                </div>

                <div class="modal-footer">
                    <input type="hidden" name="product_id" id="product_id" value="" />
                    <input type="submit" name="submit" class="btn btn-info" value="Edit" />
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
$(document).ready(function(){
 loadpage();
 function loadpage()
 {
  $.ajax({
   url:"fetch.php",
   method:"POST",
   success:function(data)
   {
    $('#products').html(data);
   }
  });
 }

 $("#addprod").on('submit', function(e){
    e.preventDefault();
    var fd = new FormData(this);
    var files = $('#multiple_files')[0].files;
    if(files.length > 0)
    {
        for(var i=0; i<files.length; i++)
        {
            fd.append("file[]", document.getElementById('multiple_files').files[i]);
        }
    }
    $.ajax({
        method: 'POST',
        url: 'submit.php',
        data: fd,
        dataType: 'json',
        contentType: false,
        cache: false,
        processData:false,
        beforeSend: function(){
            $('.submitBtn').attr("disabled","disabled");
            $('#addprod').css("opacity",".5");
        },
        success: function(response){
            $('.statusMsg').html('');
            if(response.status == 1){
                $('#addprod')[0].reset();
                $('.statusMsg').html('<p class="alert alert-success">'+response.message+'</p>');
            }
            else
            {
                $('.statusMsg').html('<p class="alert alert-danger">'+response.message+'</p>');
            }
            $('#addprod').css("opacity","");
            $(".submitBtn").removeAttr("disabled");
            loadpage();
        }
    });
    });


    // File type validation
    $("#multiple_files").change(function() {
        var file = this.files[0];
        var fileType = file.type;
        var match = ['image/jpeg', 'image/png', 'image/jpg'];
        if(!((fileType == match[0]) || (fileType == match[1]) || (fileType == match[2]))){
            alert('Sorry, only JPG, JPEG, & PNG files are allowed to upload.');
            $("#multiple_files").val('');
            return false;
        }
    });
 
 $(document).on('click', '.edit', function(){
  var product_id = $(this).attr("id");
  $.ajax({
   url:"edit.php",
   method:"post",
   data:{id:product_id},
   dataType:"json",
   success:function(data)
   {
    $('#editmodal').modal('show');
    $('#product_id').val(product_id);//////////////////////////////////
    $('#product_name').val(data.product_name);
    $('#product_price').val(data.product_price);
    $('#product_description').val(data.product_description);
   }
  });
 }); 
 
 $(document).on('click', '.delete', function(){
  var product_id = $(this).attr("id");
  if(confirm("Are you sure you want to remove it?"))
  {
   $.ajax({
    url:"delete.php",
    method:"POST",
    data:{product_id:product_id},
    success:function(data)
    {
        $('#msg').html(data);
        loadpage();
        alert("Product removed");
    }
   });
  }
 });
 
 $('#edit_image_form').on('submit', function(e){
  e.preventDefault();
    var fd2 = new FormData(this);
//   {
//     product_id: $('#product_id').val(),
//     product_name: $('#product_name').val(),
//     product_price: $('#product_price').val(),
//     product_description: $('#product_description').val(),
//   }
  for(var pair of fd2.entries()) {
        console.log(pair[0]+ ', '+ pair[1]);
    }
    $.ajax({
        method: "POST",
        url:"update.php",
        data: fd2,
        cache: false,
        processData: false,
        contentType: false,
        success:function(data)
        {
            $('#editmodal').modal('hide');
            loadpage();
            alert('Product Details updated');
        }
    });
//   }
 });
});
</script>