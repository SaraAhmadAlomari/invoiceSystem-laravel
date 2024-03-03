@extends('layouts.master')
@section('title')
المنتجات-برنامج الفواتير
@stop
@section('css')
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/jquery.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/css/responsive.dataTables.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/select2/css/select2.min.css')}}" rel="stylesheet">
@endsection
@section('page-header')
				<!-- breadcrumb -->
				<div class="breadcrumb-header justify-content-between">
					<div class="my-auto">
						<div class="d-flex">
							<h4 class="content-title mb-0 my-auto">الاعدادات</h4><span class="text-muted mt-1 tx-13 mr-2 mb-0">/ المنتجات</span>
						</div>
					</div>

				</div>
				<!-- breadcrumb -->
@endsection
@section('content')
				<!-- row -->
				<div class="row">
                    <div class="col-xl-12">
                        <div class="card">
                            <div class="card-header pb-0">
                             @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif
                            @if (session()->has('Add'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session()->get('Add') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (session()->has('delete'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session()->get('delete') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif

                            @if (session()->has('edit'))
                                <div class="alert alert-success alert-dismissible fade show" role="alert">
                                    <strong>{{ session()->get('edit') }}</strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                            @endif
                            <a class="modal-effect btn btn-outline-primary btn-block" data-effect="effect-scale" data-toggle="modal" href="#modaldemo1">اضافة منتج</a>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table text-md-nowrap" id="example1">
                                        <thead>
                                            <tr>
                                                <th class="wd-15p border-bottom-0">#</th>
                                                <th class="wd-15p border-bottom-0">اسم المنتج</th>
                                                <th class="wd-15p border-bottom-0">اسم القسم</th>
                                                <th class="wd-20p border-bottom-0"> ملاحظات</th>
                                                <th class="wd-15p border-bottom-0"> العمليات</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $i=1;
                                            @endphp


                                             @foreach ($products as $product)
                                                   <tr>
                                                    <td>{{$i++}}</td>
                                                    <td>{{$product->product_name}}</td>
                                                    <td>{{$product->section->section_name}}</td>
                                                    <td>{{$product->description}}</td>
                                                    <td>

                                                        <a class="modal-effect btn btn-sm btn-info" data-effect="effect-scale"
                                                            data-id="{{$product->id}}"
                                                            data-product_name="{{$product->product_name}}"
                                                            data-section_name="{{$product->section->section_name}}"
                                                            data-description="{{$product->description}}" data-toggle="modal"
                                                            href="#modeldemo2" title="تعديل"><i class="las la-pen"></i></a>


                                                        <a class="modal-effect btn btn-sm btn-danger" data-effect="effect-scale"
                                                            data-id="{{$product->id}}" data-product_name="{{$product->product_name}}"
                                                            data-toggle="modal" href="#modeldemo3" title="حذف"><i
                                                            class="las la-trash"></i></a>

                                                    </td>
                                                </tr>

                                             @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>

        <!-- Basic modal -->
		<div class="modal" id="modaldemo1">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">اضافة منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
                <form action="{{route('products.store')}}" method="POST">
					<div class="modal-body">
                            {{csrf_field()}}
                            <div class="form-group">
                                <label for="product_name" class="col-form-label">اسم المنتج</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>
                            <div class="form-group">
                                <label for="section_name" class="col-form-label">اسم القسم</label>
                                <select class="form-control" name="section_id" id="section_id">
                                    <option value="" selected disabled>--حدد القسم--</option>
                                    @foreach ($sections as $section)
                                        <option  value="{{$section->id}}">{{$section->section_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-form-label">ملاحظات</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
					</div>
					<div class="modal-footer">
                        <button type="submit" class="btn btn-success">تأكيد</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
					</div>
                </form>
				</div>
			</div>
		</div>
		<!-- End Basic modal -->

        <!--start edit modle  -->
        <div class="modal" id="modeldemo2">
			<div class="modal-dialog" role="document">
				<div class="modal-content modal-content-demo">
					<div class="modal-header">
						<h6 class="modal-title">تعديل منتج</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
					</div>
                <form action="products/update" method="POST">
					<div class="modal-body">
                            {{ method_field('patch') }}
                            {{csrf_field()}}
                            <input type="hidden" id="id" name="id">
                            <div class="form-group">
                                <label for="product_name" class="col-form-label">اسم المنتج</label>
                                <input type="text" class="form-control" id="product_name" name="product_name">
                            </div>
                            <div class="form-group">
                                <label for="section_name" class="col-form-label">اسم القسم</label>
                                <select class="form-control" name="section_name" id="section_name">
                                    @foreach ($sections as $section)
                                        <option>{{$section->section_name}}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="description" class="col-form-label">ملاحظات</label>
                                <textarea class="form-control" id="description" name="description"></textarea>
                            </div>
					</div>
					<div class="modal-footer">
                        <button type="submit" class="btn btn-success">تعديل</button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">اغلاق</button>
					</div>
                </form>
				</div>
			</div>
		</div>
        <!--end edit modle  -->

        <!-- start delete modle -->

    <!-- delete -->
    <div class="modal" id="modeldemo3">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content modal-content-demo">
                <div class="modal-header">
                    <h6 class="modal-title">حذف القسم</h6><button aria-label="Close" class="close" data-dismiss="modal"
                        type="button"><span aria-hidden="true">&times;</span></button>
                </div>
                <form action="products/destroy" method="post">
                    {{ method_field('delete') }}
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <p>هل انت متاكد من عملية الحذف ؟</p><br>
                        <input type="hidden" name="id" id="id" value="">
                        <input class="form-control" name="product_name" id="product_name" type="text" readonly>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">الغاء</button>
                        <button type="submit" class="btn btn-danger">تاكيد</button>
                    </div>
            </div>
            </form>
        </div>
    </div>

        <!-- end delete modle -->

				</div>
				<!-- row closed -->
			</div>
			<!-- Container closed -->
		</div>
		<!-- main-content closed -->
@endsection
@section('js')
<!-- Internal Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.dataTables.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/responsive.bootstrap4.min.js')}}"></script>
<!--Internal  Datatable js -->
<script src="{{URL::asset('assets/js/table-data.js')}}"></script>
<!-- Internal Modal js-->
<script src="{{URL::asset('assets/js/modal.js')}}"></script>
<script>
    $('#modeldemo2').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var section_name = button.data('section_name')
        var description = button.data('description')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
        modal.find('.modal-body #section_name').val(section_name);
        modal.find('.modal-body #description').val(description);
    })
</script>
<script>
    $('#modeldemo3').on('show.bs.modal', function(event) {
        var button = $(event.relatedTarget)
        var id = button.data('id')
        var product_name = button.data('product_name')
        var modal = $(this)
        modal.find('.modal-body #id').val(id);
        modal.find('.modal-body #product_name').val(product_name);
    })

</script>
@endsection
