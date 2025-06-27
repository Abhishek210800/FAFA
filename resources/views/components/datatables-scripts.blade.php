<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>

<script>
    $(document).ready(function () {
        const tableElement = $('#recentCasesTable');
        const spinner = $('#loadingSpinner');
        const container = $('#datatableContainer');

        const table = tableElement.DataTable({
            order: [[0, 'asc']],
            pageLength: 20,
            dom: '<"flex flex-col md:flex-row justify-between items-center mb-4 gap-2"lf>t<"flex justify-between items-center mt-4"ip>',
            initComplete: function () {
                spinner.addClass('opacity-0 pointer-events-none');
                container.removeClass('opacity-0 invisible').addClass('opacity-100 visible');
            }
        });
    });
</script>
