@if (Session::has('info'))
<div class="alert alert-info">
    {{ Session::get('info') }}
    <button class="close" data-dismiss="alert">
        &times;
    </button>
</div>
@endif