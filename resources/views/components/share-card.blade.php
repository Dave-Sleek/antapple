<div class="share-row mt-3">

    <span class="share-label small text-muted me-2">
        <i class="bi bi-share me-1"></i> Share
    </span>

    <div class="share-icons">

        {{-- WhatsApp --}}
        <a href="https://wa.me/?text={{ urlencode($shareText . ' - Apply here: ' . $jobUrl) }}" target="_blank"
            class="share-btn whatsapp">
            <i class="bi bi-whatsapp"></i>
        </a>

        {{-- Facebook --}}
        <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode($jobUrl) }}" target="_blank"
            class="share-btn facebook">
            <i class="bi bi-facebook"></i>
        </a>

        {{-- LinkedIn --}}
        <a href="https://www.linkedin.com/shareArticle?mini=true&url={{ urlencode($jobUrl) }}&title={{ urlencode($shareText) }}"
            target="_blank" class="share-btn linkedin">
            <i class="bi bi-linkedin"></i>
        </a>

        {{-- Twitter/X --}}
        <a href="https://x.com/intent/tweet?url={{ urlencode($jobUrl) }}&text={{ urlencode($shareText) }}"
            target="_blank" class="share-btn x">
            <i class="fab fa-x"></i>
        </a>

        {{-- Copy --}}
        <button onclick="copyLink('{{ $jobUrl }}', this)" class="share-btn copy">
            <i class="bi bi-link-45deg"></i>
        </button>

    </div>
</div>
