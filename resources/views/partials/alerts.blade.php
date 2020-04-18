@if(Session::has('success'))
  <script>
    Materialize.toast('{{ Session::get('success') }}', 5000, 'dialog-success');
  </script>
@endif
@if(Session::has('error'))
  <script>
    Materialize.toast('{{ Session::get('error') }}', 5000, 'dialog-error');
  </script>
@endif
@if(Session::has('info'))
  <script>
    Materialize.toast('{{ Session::get('info') }}', 5000);
  </script>
@endif