<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
<script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
<script>
    function toastResult(gravity, position, text, status) {
        Toastify({
            text: text,
            duration: 3000,
            close: true,
            gravity: gravity,
            position: position,
            style : {
                background : status == 'error' ? "#F87171" : "#86EFAC"
            }
        }).showToast();
    }
</script>
{{-- Success --}}
@if (Session::has('success'))
    <script>
        if (window.innerWidth <= 768) {
            toastResult("top", "center", "{{ Session::get('success') }}", "success")
        } else {
            toastResult("bottom", "right", "{{ Session::get('success') }}", "success")
        }
    </script>
@endif

{{-- Failed/Errpr --}}
@if (Session::has('error'))
    <script>
        if (window.innerWidth <= 768) {
            toastResult("top", "center", "{{ Session::get('error') }}", "error")
        } else {
            toastResult("bottom", "right", "{{ Session::get('error') }}", "error")
        }
    </script>
@endif

 {{-- Auto By Laravel Validate --}}
 @if ($errors->any())
 @foreach ($errors->all() as $item)
     <script>
         toastResult("bottom", "right", @json($item), "error");
     </script>
 @endforeach

@endif
