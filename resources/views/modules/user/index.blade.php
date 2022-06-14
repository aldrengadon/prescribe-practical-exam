@extends('layouts.app')
@section('content')
    <script type="application/javascript">
        var users = {!! json_encode($users) !!};
        var userRoles = {!! json_encode($userRoles) !!};
        var permissions = {!! json_encode($permissions) !!};
    </script>
    <user-index></user-index>
@endsection