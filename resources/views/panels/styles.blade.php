{{-- Vendor Styles --}}
<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:300,400,500,600">
<link rel="stylesheet" href="{{ asset('vendors/css/vendors.min.css') }}">
<link rel="stylesheet" href="{{ asset('vendors/css/ui/prism.min.css') }}">

<!-- Theme Styles -->
<link rel="stylesheet" href="{{ asset('css/bootstrap.css') }}">
<link rel="stylesheet" href="{{ asset('css/bootstrap-extended.css') }}">
<link rel="stylesheet" href="{{ asset('css/colors.css') }}">
<link rel="stylesheet" href="{{ asset('css/components.css') }}">




{{-- {!! Helper::applClasses() !!} --}}
@php 
$configData = Helper::applClasses();
@endphp

@if($configData['theme'] == 'dark-layout')
    <link rel="stylesheet" href="{{ asset('css/themes/dark-layout.css') }}">
@endif
@if($configData['theme'] == 'semi-dark-layout')
    <link rel="stylesheet" href="{{ asset(mix('css/themes/semi-dark-layout.css')) }}">
@endif

<!-- Page Styles -->
<!-- Page Styles -->
<link rel="stylesheet" href="{{ asset('css/core/menu/menu-types/vertical-menu.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ asset('vendors/css/tables/datatable/datatables.min.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ asset('vendors/css/forms/select/select2.min.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/sweetalert2.min.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ asset('vendors/css/tables/ag-grid/ag-grid.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ asset('vendors/css/tables/ag-grid/ag-theme-material.css') }}" type="text/css" >
<link rel="stylesheet" href="{{ asset('vendors/css/extensions/nouislider.min.css') }}" type="text/css" >


<link rel="stylesheet" href="{{ asset('css/app-user.css') }}">
<link rel="stylesheet" href="{{ asset('css/aggrid.css') }}">

<link rel="stylesheet" href="{{ asset('css/noui-slider.css') }}">
<link rel="stylesheet" href="{{ asset('css/app-ecommerce-shop.css') }}">
<link rel="stylesheet" href="{{ asset('css/wizard.css') }}">

<style type="text/css">
    table.dataTable thead .sorting::after, table.dataTable thead .sorting_asc::after, table.dataTable thead .sorting_desc::after, table.dataTable thead .sorting_asc_disabled::after, table.dataTable thead .sorting_desc_disabled::after {
        right: 0.5em;
        content: "\E842";
    }
    table.dataTable thead .sorting::before, table.dataTable thead .sorting_asc::before, table.dataTable thead .sorting_desc::before, table.dataTable thead .sorting_asc_disabled::before, table.dataTable thead .sorting_desc_disabled::before {
        right: 1em;
        content: "\E845";
    }
</style>
<script src="{{ asset('js/jquery.min.js')}}"></script>
{{-- Vendor Scripts --}}
<script src="{{ asset('vendors/js/vendors.min.js')}}"></script>
<script src="{{ asset('vendors/js/ui/prism.min.js')}}"></script>



<!-- Page Scripts -->
<script src="{{ asset('vendors/js/forms/select/select2.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.min.js') }}"></script>


<script src="{{ asset('vendors/js/tables/datatable/datatables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.buttons.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/datatables.checkboxes.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/pdfmake.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.print.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/vfs_fonts.js') }}"></script>
<script src="{{ asset('vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/sweetalert2.all.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.bootstrap.min.js') }}"></script>
<script src="{{ asset('vendors/js/tables/datatable/buttons.html5.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/select/select2.full.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/validation/jqBootstrapValidation.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/wNumb.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/nouislider.min.js') }}"></script>
<script src="{{ asset('vendors/js/extensions/jquery.steps.min.js') }}"></script>
<script src="{{ asset('vendors/js/forms/spinner/jquery.bootstrap-touchspin.js') }}"></script>
<script src="{{asset('vendors/js/forms/validation/jquery.validate.min.js')}}"></script>
<script src="{{asset('vendors/js/extensions/toastr.min.js')}}"></script>
<script src="{{asset('vendors/js/pagination/jquery.twbsPagination.min.js')}}"></script>



