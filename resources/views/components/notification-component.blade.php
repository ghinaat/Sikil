<div>

</div>
@push('js')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
$(document).ready(function() {
    // Ambil pesan sukses dari session (jika ada) dan tampilkan menggunakan SweetAlert2
    var successMessage = '{{ session('success_message') }}';
    var successChanged = '{{ session('success_changed') }}';
    var successDeleted = '{{ session('success_deleted') }}';
    if (successMessage) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: successMessage,
        });
    }
    if (successChanged) {
        Swal.fire({
            icon: 'success',
            title: 'Changed!',
            text: successChanged,
        });
    }
    if (successDeleted) {
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: successDeleted,
        });
    }
});

function notificationBeforeDelete(event, el, dt) {
    event.preventDefault();
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!'
    }).then((result) => {
        if (result.isConfirmed) {
            // Jika pengguna mengonfirmasi penghapusan, lakukan penghapusan dengan mengirimkan form
            $("#delete-form").attr('action', $(el).attr('href'));
            $("#delete-form").submit();
        }
    });
}
</script>
@endpush