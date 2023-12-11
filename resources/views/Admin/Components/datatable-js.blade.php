<script src="{{ asset(mix('vendors/js/tables/datatable/jquery.dataTables.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.bootstrap5.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/dataTables.responsive.min.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/tables/datatable/responsive.bootstrap5.js')) }}"></script>
<script src="{{ asset(mix('vendors/js/forms/select/select2.full.min.js')) }}"></script>

<script src="{{ asset(mix('js/scripts/tables/table-datatables-advanced.js')) }}"></script>
@if (session()->get('locale') == 'en')
    <script src="{{ asset(mix('js/scripts/tables/datatable_en.js')) }}"></script>
@else
    <script src="{{ asset(mix('js/scripts/tables/datatable.js')) }}"></script>
@endif
