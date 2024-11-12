
    let sortDirection = {};

    function sortTable(columnIndex) {
        const table = document.querySelector(".custom-table tbody");
        const rows = Array.from(table.querySelectorAll("tr"));

        sortDirection[columnIndex] = !sortDirection[columnIndex];
        const sortedRows = rows.sort((a, b) => {
            const cellA = a.cells[columnIndex].textContent.trim().toLowerCase();
            const cellB = b.cells[columnIndex].textContent.trim().toLowerCase();

            if (!isNaN(cellA) && !isNaN(cellB)) return sortDirection[columnIndex] ? cellA - cellB : cellB - cellA;
            return sortDirection[columnIndex] ? cellA.localeCompare(cellB) : cellB.localeCompare(cellA);
        });

        sortedRows.forEach(row => table.appendChild(row));
        updateSortIndicators(columnIndex);
    }

    function updateSortIndicators(columnIndex) {
        document.querySelectorAll(".custom-table th .sort-icon").forEach((header) => {
            header.className = `sort-icon ${header.getAttribute('data-column') == columnIndex ? (sortDirection[columnIndex] ? 'asc' : 'desc') : 'unsorted'}`;
        });
    }





$(function() {
    var start = moment("{{ request('start_date') ? request('start_date') : now()->format('Y-m-d') }}");
    var end = moment("{{ request('end_date') ? request('end_date') : now()->format('Y-m-d') }}");

    function cb(start, end) {
        $('#reportrange span').html(start.format('DD-MM-YYYY') + ' - ' + end.format('DD-MM-YYYY'));
        $('#start_date').val(start.format('YYYY-MM-DD'));
        $('#end_date').val(end.format('YYYY-MM-DD'));
    }

    $('#reportrange').daterangepicker({
        startDate: start,
        endDate: end,
        ranges: {
            'Today': [moment(), moment()],
            'Yesterday': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
            'Last 7 Days': [moment().subtract(6, 'days'), moment()],
            'Last 30 Days': [moment().subtract(29, 'days'), moment()],
            'This Month': [moment().startOf('month'), moment().endOf('month')],
            'Last Month': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
        }
    }, cb);

    $('#reportrange').on('apply.daterangepicker', function(ev, picker) {
        // Set the hidden inputs for start_date and end_date
        $('#start_date').val(picker.startDate.format('YYYY-MM-DD'));
        $('#end_date').val(picker.endDate.format('YYYY-MM-DD'));
        
        // Automatically submit the form after selecting a date range
        $('#classSelectForm').submit();
    });

    cb(start, end);
});

// Print function
function printForm() {
    window.print();
}

function updateHeaderText() {
    var classSelect = document.getElementById('class_id');
    var selectedClass = classSelect.options[classSelect.selectedIndex].text;
    document.getElementById('classText').textContent = 'Class: ' + selectedClass;

    // Get the end date from the date range picker and format it
    var endDate = document.getElementById('end_date').value;
    var formattedEndDate = moment(endDate, "YYYY-MM-DD").format("DD-MM-YYYY");
    document.getElementById('dateText').textContent = 'Date: ' + formattedEndDate;
}



// Call updateHeaderText when the page loads
document.addEventListener('DOMContentLoaded', updateHeaderText);

// Update header text when class or date changes
document.getElementById('class_id').addEventListener('change', updateHeaderText);
$('#reportrange').on('apply.daterangepicker', function(ev, picker) {
    // ... (previous code remains unchanged) ...
    updateHeaderText();
});
