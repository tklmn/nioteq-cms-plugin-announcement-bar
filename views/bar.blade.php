@php
    $abEnabled = cms()->settings()->get('announcement_bar.enabled', '0');
    $abMessage = cms()->settings()->get('announcement_bar.message', '');
    $abBg = cms()->settings()->get('announcement_bar.bg_color', '#fbbf24');
    $abText = cms()->settings()->get('announcement_bar.text_color', '#1c1917');
    $abDismissible = cms()->settings()->get('announcement_bar.dismissible', '1');
    $abPosition = cms()->settings()->get('announcement_bar.position', 'top');
    $abLinkUrl = cms()->settings()->get('announcement_bar.link_url', '');
    $abLinkText = cms()->settings()->get('announcement_bar.link_text', '');
@endphp

@if($abEnabled === '1' && $abMessage)
<div id="announcement-bar"
     style="background-color: {{ e($abBg) }}; color: {{ e($abText) }};"
     class="fixed left-0 right-0 z-50 text-center text-sm py-2 px-4 shadow-sm {{ $abPosition === 'bottom' ? 'bottom-0' : 'top-0' }}">
    <span>{{ e($abMessage) }}</span>
    @if($abLinkUrl && $abLinkText)
        <a href="{{ e($abLinkUrl) }}" style="color: {{ e($abText) }};" class="ml-2 underline font-medium hover:opacity-80">{{ e($abLinkText) }}</a>
    @endif
    @if($abDismissible === '1')
        <button onclick="document.getElementById('announcement-bar').remove();document.body.style.removeProperty('{{ $abPosition === 'bottom' ? 'padding-bottom' : 'padding-top' }}')" style="color: {{ e($abText) }};" class="absolute right-3 top-1/2 -translate-y-1/2 hover:opacity-60 transition-opacity" aria-label="Dismiss">
            <i class="bi bi-x-lg text-xs"></i>
        </button>
    @endif
</div>
<script>
    (function() {
        var bar = document.getElementById('announcement-bar');
        if (bar) {
            var prop = '{{ $abPosition === "bottom" ? "padding-bottom" : "padding-top" }}';
            document.body.style[prop === 'padding-top' ? 'paddingTop' : 'paddingBottom'] = bar.offsetHeight + 'px';
        }
    })();
</script>
@endif
