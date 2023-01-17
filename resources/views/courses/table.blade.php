@section('app_css')
    @include('layouts.datatables_css')
@endsection

{!! $dataTable->table(['width' => '100%', 'class' => 'table table-striped table-bordered']) !!}

@push('app_js')
    @include('layouts.datatables_js')
    {!! $dataTable->scripts() !!}
    
<script type="text/javascript">
$(document).ready(function() {
    /* Override Export Button Actions */
    //CSV Button
    $(document).on('click', '.buttons-csv', (e) => {
        e.preventDefault();
        var url = $(this).attr("href");
        window.open(url,"_blank");
    });
    //Excel Button
    $(document).on('click', '.buttons-excel', (e) => {
        e.preventDefault();
        var url = $(this).attr('href');
        window.open(url,"_blank");
    });
    
    //PDF Button
    $(document).on('click', '.buttons-pdf', (e) => {
        e.preventDefault();
        var url = $(this).attr('href');
        window.open(url,"_blank");
    }); 
});
</script>
@endpush