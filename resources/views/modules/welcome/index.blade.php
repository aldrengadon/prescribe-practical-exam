@extends('layouts.app')
@section('content')
    <script type="application/javascript">
        var imageName = {!! json_encode($imageName) !!};
    </script>
    <welcome-index></welcome-index>
@endsection