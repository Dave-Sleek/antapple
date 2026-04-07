@extends('layouts.app')

@section('content')
    <div class="d-flex justify-content-center align-items-center" style="height:70vh;">
        <div class="text-center">
            <h3>Redirecting to payment...</h3>
            <p>Please do not close the window.</p>
            <div class="spinner-border text-primary mt-3" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
    </div>

    <script>
        // Redirect immediately
        window.location.href = "{{ $paymentRedirectUrl ?? '#' }}";
    </script>
@endsection
