{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    @foreach ($opportunities as $opportunity)
        <url>
            <loc>
                {{ route('opportunities.show', [
                    'uuid' => $opportunity->uuid,
                    'slug' => $opportunity->slug,
                ]) }}
            </loc>
            <lastmod>{{ $opportunity->updated_at->toDateString() }}</lastmod>
        </url>
    @endforeach

</urlset>
