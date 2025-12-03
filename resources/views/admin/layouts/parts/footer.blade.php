<script data-navigate-once src="{{ asset('admin-asset/js/bootstrap.bundle.min.js') }}"></script>
<script data-navigate-once src="{{ asset('admin-asset/js/all.min.js') }}"></script>
<script data-navigate-once src="https://cdn.jsdelivr.net/npm/chart.js"></script>
{{--<script data-navigate-once src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>--}}
{{--<script data-navigate-once src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>--}}
<script data-navigate-once src="//cdn.jsdelivr.net/npm/sweetalert2@10"></script>
<script data-navigate-once src="{{ asset('admin-asset/js/main.js') }}"></script>
@vite(['resources/js/admin.js'])
<script type="module">
    const Toast = Swal.mixin({
        toast: true,
        position: 'bottom',
        showConfirmButton: false,
        showCloseButton: true,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    });

    window.addEventListener('alert', ({
        detail: {
            type,
            message
        }
    }) => {
        Toast.fire({
            icon: type,
            title: message
        })
    })
</script>

<script>
    function onlyNumbers(event) {
      const value = event.target.value;
      // Remove anything that is not a digit
      event.target.value = value.replace(/[^0-9]/g, '');
    }
  </script>

@livewireScripts
@stack('js')
