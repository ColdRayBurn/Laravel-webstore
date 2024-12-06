@push('header')
  <script src="{{ asset('vendor/swiper/swiper-bundle.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset('vendor/swiper/swiper-bundle.min.css') }}">
@endpush

<section class="module-item {{ $design ? 'module-item-design' : ''}}" id="module-{{ $module_id }}">
  @include('design._partial._module_tool')

  <div class="module-info mb-3 mb-md-5 {{ !$content['full'] ? 'container' : '' }}">
    <div class="swiper module-swiper-{{ $module_id }} module-slideshow">
      <div class="swiper-wrapper">
        @foreach($content['images'] as $image)
        <div class="swiper-slide">
          <a href="{{ $image['link']['link'] ?: 'javascript:void(0)' }}" class="d-flex justify-content-center"><img
              src="{{ $image['image'] }}" class="img-fluid"></a>
        </div>
        @endforeach
      </div>
      <div class="swiper-pagination slideshow-pagination-{{ $module_id }}"></div>
      <div class="swiper-button-prev slideshow-btnprev-{{ $module_id }}"></div>
      <div class="swiper-button-next slideshow-btnnext-{{ $module_id }}"></div>
    </div>
  </div>

  <script>
    function slideshowSwiper() {
      new Swiper ('.module-swiper-{{ $module_id }}', {
        loop: '{{ count($content['images']) > 1 ? true : false }}',
        autoplay: true,
        pauseOnMouseEnter: true,
        clickable :true,


        pagination: {
          el: '.slideshow-pagination-{{ $module_id }}',
          clickable :true
        },


        navigation: {
          nextEl: '.slideshow-btnnext-{{ $module_id }}',
          prevEl: '.slideshow-btnprev-{{ $module_id }}',
        },
      })
    }

  @if ($design)
    bk.loadStyle('{{ asset('vendor/swiper/swiper-bundle.min.css') }}');
    bk.loadScript('{{ asset('vendor/swiper/swiper-bundle.min.js') }}', () => {
      slideshowSwiper();
    })
  @else
    slideshowSwiper();
  @endif
  </script>
</section>
