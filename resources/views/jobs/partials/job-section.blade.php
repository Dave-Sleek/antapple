<div class="mt-5">
    <h3 class="h5 fw-bold mb-3">
        {{ $title }}
    </h3>

    <div class="row g-4">

        @foreach ($jobs as $job)
            <div class="col-md-6 col-lg-4">
                <x-job-card :job="$job" />
            </div>
        @endforeach

    </div>
</div>
