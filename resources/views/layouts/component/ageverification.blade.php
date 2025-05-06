@if (!Cookie::has('visitor_id'))
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Age Verification',
            text: 'You must be 18 years or older to enter this site.',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'I am over 18',
            cancelButtonText: 'Leave',
            allowOutsideClick: false,
            allowEscapeKey: false,
            backdrop: true,
            reverseButtons: true
        }).then((result) => {
            if (result.isConfirmed) {
                fetch('{{ route('age.verify.submit') }}', {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Content-Type': 'application/json'
                    },
                    body: JSON.stringify({ confirm_age: 1 })
                })
                .then(response => {
                    if (response.ok) {
                        location.reload();
                    } else {
                        Swal.fire('Error', 'Something went wrong verifying your age.', 'error');
                    }
                });
            } else {
                window.location.href = 'https://google.com'; // or wherever you want to send users
            }
        });
    });
</script>
@endif
