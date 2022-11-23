@extends('admin/layouts/app')
@section('title', 'Product')
@section('page_heading', 'Product Edit')
@section('breadcrumb')
<ol class="breadcrumb float-sm-right">
   <li class="breadcrumb-item"><a href="#">Home</a></li>
   <li class="breadcrumb-item"><a href="{{url('admin/product')}}">Products</a></li>
   <li class="breadcrumb-item active">Edit Product</li>
</ol>
@endsection
@section('content')
<!-- Main content -->
<section class="content">
   <div class="container-fluid">
      <div class="row">
         <!-- left column -->
         <div class="col-md-12">
            <!-- jquery validation -->
            <div class="card card-primary">
               <div class="card-header">
                  <h3 class="card-title">Product <small>information</small></h3>
               </div>
               <!-- /.card-header -->
               <!-- form start -->
               <form action="{{url('admin/product/'.$product->id.'/update')}}" method="post" enctype="multipart/form-data">
                  @csrf
                  <div class="card-body">
                     <div class="row">
                        <div class="col-6">
                            
                            <div class="form-group">
                              <label>Shop Name</label>
                              <select name="category_id" class="form-control" data-placeholder="Select a Category" style="width: 100%;">
                              @foreach($categories as $category)
                              <option value="{{$category->id}}" {{($category->id == $product->category_id )?"selected":""}}>{{$category->category_name}}</option>
                              @endforeach
                              </select>
                            </div>
                           
                           <div class="form-group">
                              <label>Categories</label>
                              <select name="subcat_id" class="form-control" data-placeholder="Select a Child Category" style="width: 100%;">
                              @foreach($subcat as $value)
                              <option value="{{ $value->id }}" {{($product->subcat_id== $value->id )?"selected":""}}>{{ $value->sub_category_name }}</option>
                              @endforeach
                              </select>
                           </div>
                          
                           <div class="form-group">
                              <label>Vendors</label>
                              <select name="vendor_id" class="form-control" data-placeholder="Select a Child Category" style="width: 100%;">
                              @foreach($vendors as $vendor)
                              <option value="{{ $vendor->id }}" {{($vendor->id == $value->vendor_id )?"selected":""}}>{{ $vendor->name }}</option>
                              @endforeach
                              </select>
                           </div>
                                
                           <label for="product_name" class="control-label mb-1">Product Name</label>
                           <input type="text" class="form-control" name="product_name" value="{{$product->product_name}}">
                           
                           <label for="product_slug" class="control-label mb-1">Product Slug</label>
                           <input type="text" class="form-control" name="product_slug" value="{{$product->product_slug}}">
                           
                           
                           <label for="regular_price" class="control-label mb-1"> Price</label>
                           <div class="input-group mb-3">
                              <input type="text" class="form-control" name="regular_price" value="{{$product->regular_price}}">
                              <div class="input-group-append">
                                 <span class="input-group-text">.00</span>
                              </div>
                           </div>
                           
                           
                           <label for="regular_price" class="control-label mb-1"> Pr Item price</label>
                           <div class="input-group mb-3">
                              <input type="text" class="form-control" name="pr_item_price" value="{{$product->pr_item_price}}">
                              <div class="input-group-append">
                                 <span class="input-group-text">.00</span>
                              </div>
                           </div>
                           {{--  
                           <div class="col-3">
                              <label for="sale_price" class="control-label mb-1">Sale Price</label>
                              <div class="input-group mb-3">
                                 <input type="text" class="form-control" name="sale_price" value="{{$product->sale_price}}">
                                 <div class="input-group-append">
                                    <span class="input-group-text">.00</span>
                                 </div>
                              </div>
                           </div>
                           --}}
                           <!-- textarea -->
                           <div class="form-group">
                              <label>Stock OR Quantity</label>
                              <input type="number" value="{{$product->stock}}" class="form-control" name="stock" value="{{old('stock')}}">
                           </div>
                           <div class="form-group">
                              <label>Long Description</label>
                              <textarea class="form-control" rows="3" name="description">
                              {{$product->description}}
                              </textarea>
                           </div>
                           <div class="form-group">
                              <label for="customFile">Product Image</label>
                              <div class="custom-file">
                                 <input type="file" class="custom-file-input" id="customFile" accept="image/*" name="product_image" onchange="loadFile(event)">
                                 <label class="custom-file-label" for="customFile">Choose file</label>
                              </div>
                           </div>
                           <!-- <div class="col-sm-6"> -->
                           <a href="{{ asset('assets/images/product/'.$product->product_image) }}" data-toggle="lightbox" id="a_output" data-title="Product Image" data-gallery="gallery">
                           <img src="{{ asset('assets/images/product/'.$product->product_image) }}" id="output" class="img-fluid mb-2" width="260" height="151" />
                           </a>
                           <!-- </div> -->
                           
                           
                        </div>
                     </div>
                  </div>
                  <!-- /.card-body -->
                  <div class="card-footer">
                     <button type="submit" class="btn btn-primary">Submit</button>
                  </div>
               </form>
            </div>
            <!-- /.card -->
         </div>
         <!--/.col (left) -->
      </div>
      <!-- /.row -->
   </div>
   <!-- /.container-fluid -->
</section>
<!-- /.content -->
@endsection
@push('scripts')
<!-- Select2 -->
<script src="{{asset('assets/backend_assets/plugins/select2/js/select2.full.min.js')}}"></script>
<!-- bootstrap color picker -->
<script src="{{asset('assets/backend_assets/plugins/bootstrap-colorpicker/js/bootstrap-colorpicker.min.js')}}"></script>
<script type="text/javascript">
   $(function () {
   
   	//Initialize Select2 Elements
       $('.select2').select2()
   
       //Initialize Select2 Elements
       $('.select2bs4').select2({
         theme: 'bootstrap4'
       })
   
       //color picker with addon
       $('.my-colorpicker2').colorpicker()
   
       $('.my-colorpicker2').on('colorpickerChange', function(event) {
   
         $(this).closest('.form-group').find('.my-colorpicker2 .fa-square').css('color', event.color.toString());
         /*$('.my-colorpicker2 .fa-square').css('color', event.color.toString());*/
       })
   
   })
   
</script>
<!-- Ekko Lightbox -->
<script src="{{asset('assets/backend_assets/plugins/ekko-lightbox/ekko-lightbox.min.js')}}"></script>
<!-- Page specific script -->
<script>
   $(function () {
       $(document).on('click', '[data-toggle="lightbox"]', function(event) {
         event.preventDefault();
         $(this).ekkoLightbox({
           alwaysShowClose: true
         });
       });
   })
</script>

<script>

    $("#product_name").keyup(function() {
      var Text = $(this).val();
      Text = Text.toLowerCase();
      Text = Text.replace(/[^\w-]+/g, '-');
      $("#product_slug").val(Text);  
    });
    
</script>


<script>
   var loadFile = function(event) {
       var image = document.getElementById('output');
       var a_image = document.getElementById('a_output');
   
       image.src = URL.createObjectURL(event.target.files[0]);
       a_image.href = URL.createObjectURL(event.target.files[0]);
   
       image.width=260;
       image.height=151;
   
       /*image.width=260;
       image.height=151;*/
   };
   
   $("#color-plus").on("click", function() {
   
   	var color_code = $(this).closest('.form-group').find('input');
   	var color = $(this).closest('.form-group').find('.fa-square').css('color');
   
   	if(color_code.val()){
   		$('.noc').last('.form-group').append('<div class="form-group"><div class="input-group"><input type="text" class="form-control" name="colors[]" value="'+color_code.val()+'"><div class="input-group-append"><span class="input-group-text"><i class="fas fa-square" style="color:'+color+'"></i></span><span class="input-group-text color-minus"><i class="fas fa-minus"></i></span></div></div></div>');
   		color_code.val("");
   		$(this).closest('.form-group').find('.fa-square').css('color','');
   	}
   	else{
   		toastr.error('Please Select Color');
   	}
   });
   $(document).on("click", ".color-minus", function() {
   	$(this).closest(".form-group").remove();
   });
   
   $("#size-plus").on("click", function(){
   	$('.nos').last('.form-group').append('<div class="form-group"><div class="input-group"><input type="text" class="form-control" name="sizes[]"><div class="input-group-append"><span class="input-group-text size-minus"><i class="fas fa-minus"></i></span></div></div></div></div>')
   });
   
   $(document).on("click", ".size-minus", function() {
   	$(this).closest(".form-group").remove();
   });
   
</script>
@endpush
@push('css')
<!-- Select2 -->
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/select2/css/select2.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
<!-- Ekko Lightbox -->
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/ekko-lightbox/ekko-lightbox.css')}}">
<!-- Bootstrap Color Picker -->
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/bootstrap-colorpicker/css/bootstrap-colorpicker.min.css')}}">
@endpush