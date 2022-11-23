@extends('layouts/app')

@section('title', 'Products')

@section('page_heading', 'Products list')


@section('content')
<div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Edit Profile</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Edit Profile</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <section class="content">
    <div class="container-fluid">
    @if (count($errors) > 0)
  <div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.<br><br>
    <ul>
       @foreach ($errors->all() as $error)
         <li>{{ $error }}</li>
       @endforeach
    </ul>
  </div>
@endif
        <div class="row">
          <div class="col-12">
<div class="card">
	<!-- /.card-header -->
	<div class="card-header">
	    <h3 class="card-title">Product list</h3>
      <div class="float-sm-right">
      @can('product-list')      
      <button type="button" class="btn btn-block btn-outline-info btn-sm" onclick="location.href='{{URL('product/create')}}';">
        <i class="fas fa-plus"></i> Create</button>
      @endcan    
      </div>
  	</div>
	<!-- /.card-header -->

    <div class="card-body">

    <table id="example1" class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Image</th>
                <th>Product Info</th>
                <th></th>
                @can('product-status')
                <th>Status</th>
                @endcan
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @foreach($products as $pro)
            @php
                $catt =\App\Models\SubCategory::where('id',$pro->subcat_id)->first();
            @endphp
            <tr>
                <td>
                <img width="90" src="{{ asset('assets/images/product/'.$pro->product_image) }}">
                </td>
                <td>
                  <strong>Product Name: </strong>{{$pro->product_name}}<br />
                  <strong>Vendor Name: </strong> @php print_r(get_name_by_id('users',$pro->vendor_id,'name')) @endphp <br />
                   <strong>Shop: </strong>
                  @foreach($pro->categories as $cat)
                    {{$cat->category_name}}
                  @endforeach
                  <br />
                  <strong>Category: </strong>
                     
                    @if(get_name_by_id('sub_categories',$pro->subcat_id,'sub_category_name') )
                    @php print_r(get_name_by_id('sub_categories',$pro->subcat_id,'sub_category_name')) @endphp
                    @else
                    N/A
                    @endif
                    <br />
                  <strong>Price: </strong>${{$pro->regular_price}} <br />
                  <strong>Stock: </strong>{{$pro->stock}} <br />
                  

                 
                  
                  <strong>Created at: </strong>{{$pro->created_at}}

                </td>
                <td>
                    <button type="button" class="btn btn-block btn-success btn-sm" onclick="window.location='{{url("admin/product/".$pro->id."/images")}}'">
                      <i class="far fa-image"></i>&nbsp;Add Image</button>

                </td>
                @can('product-status')
                <td>
                    <div class="form-group">
                        <div class="custom-control custom-switch custom-switch-off-danger custom-switch-on-success">
                            <input type="checkbox" class="custom-control-input switch-input" id="{{$pro->id}}" {{($pro->status==1)?"checked":""}}>
                        <label class="custom-control-label" for="{{$pro->id}}"></label>
                        </div>
                    </div>
                </td>
                @endcan
                <td class="project-actions text-center">
                    @can('product-edit')
                    <a class="btn btn-info btn-sm" href="{{url('admin/product/'.$pro->id.'/edit')}}">
                        <i class="fas fa-pencil-alt"></i>
                    </a>
                    @endcan
                    
                    @can('product-delete')
                    <a class="btn btn-danger btn-sm" href="{{route('productdelete',$pro->id)}}">
                        <i class="fas fa-trash"></i>
                    </a>
                    @endcan
                </td>
            </tr>
            @endforeach
            </tbody>
    </table>
      <!-- table  -->
	    </table>
	  </div>
	  <!-- /.card-body -->
</div>
</section>
</div>

@endsection

@push('scripts')
<!-- DataTables  & Plugins -->

@push('scripts')
<!-- DataTables  & Plugins -->
<script src="{{asset('assets/backend_assets/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-responsive/js/responsive.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/dataTables.buttons.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/jszip/jszip.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/pdfmake/pdfmake.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/pdfmake/vfs_fonts.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.html5.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.print.min.js')}}"></script>
<script src="{{asset('assets/backend_assets/plugins/datatables-buttons/js/buttons.colVis.min.js')}}"></script>

<script>
  $(function () {
    $("#example1").DataTable({
      "responsive": true, "lengthChange": false, "autoWidth": false
    }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
    $('#example2').DataTable({
      "paging": true,
      "lengthChange": false,
      "searching": false,
      "ordering": true,
      "info": true,
      "autoWidth": false,
      "responsive": true,
    });
  });
</script>

<script>

$(".switch-input").change(function(){

    if(this.checked)
        var status=1;
    else
        var status=0;
    $.ajax({
        url: '{!! URL("admin/product/'+this.id+'/status") !!}',
        type: 'post',
        /*dataType: 'json',*/
        data: {'_token': '{{ csrf_token() }}','user_id': this.id,'status':status},
        success: function (response) {
            if(status==1)
              toastr.success(response+" turned ON");
            else
              toastr.error(response+" turned OFF");
        }, error: function (error) {
            toastr.error("Some error occured!");
        }
    });
});

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

@endpush

@push('css')
<!-- DataTables -->
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/datatables-bs4/css/dataTables.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/datatables-responsive/css/responsive.bootstrap4.min.css')}}">
<link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/datatables-buttons/css/buttons.bootstrap4.min.css')}}">

<!-- Ekko Lightbox -->
  <link rel="stylesheet" href="{{asset('assets/backend_assets/plugins/ekko-lightbox/ekko-lightbox.css')}}">
@endpush
