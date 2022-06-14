@extends('layouts.app')
@section('content')
    <script type="application/javascript">
        var roles = {!! json_encode($roles) !!};
        var permissions = {!! json_encode($permissions) !!};
    </script>
    <role-index></role-index>
@endsection