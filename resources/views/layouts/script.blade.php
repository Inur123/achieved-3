<script src="{{ asset('template/assets/libs/jquery/dist/jquery.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('template/assets/js/sidebarmenu.js') }}"></script>
<script src="{{ asset('template/assets/js/app.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/apexcharts/dist/apexcharts.min.js') }}"></script>
<script src="{{ asset('template/assets/libs/simplebar/dist/simplebar.js') }}"></script>
<script src="{{ asset('template/assets/js/dashboard.js') }}"></script>


<script>
    // Hide loading screen once the page is fully loaded
    window.addEventListener("load", function() {
        document.getElementById("loading-screen").style.display = "none";
    });
</script>

<script>
    document.addEventListener("DOMContentLoaded", function() {
        let toastElements = document.querySelectorAll('.toast');
        toastElements.forEach(function(toastEl) {
            let bsToast = new bootstrap.Toast(toastEl, { delay: 3000 });
            bsToast.show();
        });
    });
</script>

<script>
    function confirmDelete(itemId) {
        Swal.fire({
            title: 'Are you sure?',
            text: "This item will be deleted!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Delete',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Find the form by the itemId (using dynamically generated ID)
                document.getElementById('delete-form-' + itemId).submit();
            }
        });
    }
</script>
