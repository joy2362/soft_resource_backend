<script src="https://code.jquery.com/jquery-3.6.0.min.js"
        integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4="
        crossorigin="anonymous"></script>
<script src="{{asset('admin/js/app.js')}}"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script type="text/javascript" src="https://cdn.datatables.net/v/bs5/dt-1.11.3/datatables.min.js"></script>
<script>
        @if ($errors->any())
            @foreach ($errors->all() as $error)
                toastr.error("{{ $error }}");
            @endforeach
        @endif

</script>
<script>
        document.addEventListener('DOMContentLoaded', function () {
        @if(Session::has('status'))
        Swal.fire({
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            title: 'Success!',
            text: '{{Session::get('status')}}',
            icon: 'success',
            position:'top-end',
            toast:true
        })
        @endif
        @if(Session::has('messege'))
        var type = "{{Session::get('alert-type','info')}}"
        switch(type){
        case 'info':
        Swal.fire({
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        title: 'Info!',
        text: '{{Session::get('messege')}}',
        icon: 'info',
        position:'top-end',
        toast:true
    })
        break;
        case 'success':
        Swal.fire({
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        title: 'Success!',
        text: '{{Session::get('messege')}}',
        icon: 'success',
        position:'top-end',
        toast:true
    })
        break;
        case 'warning':
        Swal.fire({
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        title: 'Warning!',
        text: '{{Session::get('messege')}}',
        icon: 'warning',
        position:'top-end',
        toast:true
    })
        break;
        case 'error':
        Swal.fire({
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        title: 'Error!',
        text: '{{Session::get('messege')}}',
        icon: 'error',
        position:'top-end',
        toast:true
    })
        break;
    }
        @endif
        $(document).on("click", "#delete", function(e){
        e.preventDefault();
        var link = $(this).attr("href");
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
        window.location.href = link;
    }
    })
    });
    });
</script>
</script>