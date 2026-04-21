{!! '<?xml version="1.0" encoding="UTF-8"?>' !!}
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Jobs by month --}}
    @foreach ($jobMonths as $m)
        <sitemap>
            <loc>{{ url("/sitemaps/jobs-{$m->year}-" . str_pad($m->month, 2, '0', STR_PAD_LEFT) . '.xml') }}</loc>
        </sitemap>
    @endforeach

    {{-- Opportunities by month --}}
    @foreach ($oppMonths as $m)
        <sitemap>
            <loc>{{ url("/sitemaps/opportunities-{$m->year}-" . str_pad($m->month, 2, '0', STR_PAD_LEFT) . '.xml') }}
            </loc>
        </sitemap>
    @endforeach

    {{-- Category sitemaps --}}
    @foreach ($categories as $category)
        <sitemap>
            <loc>{{ url('/sitemaps/category/' . $category->slug . '.xml') }}</loc>
        </sitemap>
    @endforeach

</sitemapindex>
