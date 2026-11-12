@extends('frontend.layouts.app')
@push('styles')
{{-- <!-- Lightbox2 CSS --> --}}
<link href="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/css/lightbox.min.css" rel="stylesheet">
@endpush

@php
  $productName = $title ?? ($productVariant->name ?? ($productVariant->product->name ?? 'Product Details'));
  $rawDesc = $productVariant->product->description ?? ($productVariant->product->product_details ?? '');
  $cleanDesc = trim(preg_replace('/\s+/', ' ', strip_tags(html_entity_decode($rawDesc, ENT_QUOTES, 'UTF-8'))));
  $fallbackDesc = !empty($cleanDesc) 
      ? \Illuminate\Support\Str::limit($cleanDesc, 160) 
      : ('Buy ' . $productName . ' online at best price from Fortier Healthcare PVT. LTD. Fast pan-India delivery on healthcare and wellness products.');
  $fallbackTitle = $productName . ' | Fortier Healthcare PVT. LTD.';
  $categoryTitle = $category->title ?? ($productVariant->category->title ?? '');
  $fallbackKeywords = implode(', ', array_filter([$productName, $categoryTitle, 'Fortier Healthcare', 'buy online', 'healthcare']));
@endphp

@section('title', $productName)
@section('meta_title', $meta_title ?? $fallbackTitle)
@section('meta_description', $meta_description ?? $fallbackDesc)
@section('meta_keywords', $meta_keywords ?? $fallbackKeywords)

@section('content')
@include('frontend.includes.breadcrumb')

<section class="product-details-page-section py-4">
  <div class="container-xxl">
    <div class="product-details-grid-wrapper">
      <div class="product-details-gallery-col">
        @include('frontend.includes.image-slide')
      </div>
      <div class="product-details-info-col">
        @include('frontend.includes.product-buy')
      </div>
    </div>
  </div>
</section>
@endsection

@push('component-scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/lightbox2/2.11.3/js/lightbox.min.js"></script>

<script>
$(document).ready(function() {
  $(document).on('click', '.po-items', function() {
    window.location.href = $(this).data('url');
  });

  $('.buy-now-btn').on('click', function() {
    const id = $(this).data('id');
    let serial = $(this).data('serial');
    $('#buy-now-form-' + serial).submit();
  });
});
</script>
@endpush