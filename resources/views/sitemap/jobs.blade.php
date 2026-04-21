{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @foreach ($jobs as $job)
        <url>
            <loc>{{ route('jobs.show', ['job' => $job->uuid, 'slug' => $job->slug]) }}</loc>
            <lastmod>{{ $job->updated_at->toDateString() }}</lastmod>
        </url>
    @endforeach

</urlset>
