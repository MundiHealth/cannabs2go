@inject ('productImageHelper', 'Webkul\Product\Helpers\ProductImage')
@inject ('wishListHelper', 'Webkul\Customer\Helpers\Wishlist')

<?php $images = $productImageHelper->getGalleryImages($product); ?>

{!! view_render_event('bagisto.shop.products.view.gallery.before', ['product' => $product]) !!}

<div class="col-xl-6 col-lg-6">

    <product-gallery></product-gallery>

</div>

{!! view_render_event('bagisto.shop.products.view.gallery.after', ['product' => $product]) !!}

@push('scripts')

    <script type="text/x-template" id="product-gallery-template">
        <div id="gallery">
            <div class="product-thumb-tab mb-30">
                <ul class="nav" id="myTab2" role="tablist">
                    <li class="nav-item" v-for='(thumb, index) in thumbs' @click="changeImage(thumb)" :class="[thumb.large_image_url == currentLargeImageUrl ? 'active' : '']" id="thumb-frame">
                        <a class="nav-link active" id="home-tab" data-toggle="tab" href="#home" role="tab" aria-selected="true" :data-image="currentLargeImageUrl" :data-zoom-image="currentOriginalImageUrl">
                            <img :src="thumb.small_image_url">
                        </a>
                    </li>
                </ul>
            </div>
            <div class="product-details-img mb-20">
                <div class="tab-content" id="myTabContent3">
                    <div class="tab-pane fade show active" id="home" role="tabpanel" >
                        <div class="product-large-img" id="img-container">
                            <img :src="currentLargeImageUrl" id="pro-img" :data-zoom-image="currentOriginalImageUrl" @mouseover="zoom()"/>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </script>

    <script>
        var galleryImages = @json($images);

        Vue.component('product-gallery', {

            template: '#product-gallery-template',

            data: function() {
                return {
                    images: galleryImages,

                    thumbs: [],

                    currentLargeImageUrl: '',

                    currentOriginalImageUrl: '',

                    counter: {
                        up: 0,
                        down: 0,
                    },

                    is_move: {
                        up: true,
                        down: true,
                    }
                }
            },

            watch: {
                'images': function(newVal, oldVal) {
                    this.changeImage(this.images[0])

                    this.prepareThumbs()
                }
            },

            created: function() {
                this.changeImage(this.images[0])

                this.prepareThumbs()
            },

            methods: {
                prepareThumbs: function() {
                    var this_this = this;

                    this_this.thumbs = [];

                    this.images.forEach(function(image) {
                        this_this.thumbs.push(image);
                    });
                },

                changeImage: function(image) {
                    $('.product-large-img').trigger('zoom.destroy');

                    this.currentLargeImageUrl = image.large_image_url;

                    this.currentOriginalImageUrl = image.original_image_url;
                },

                zoom: function(){
                    $('.product-large-img').zoom({
                        onZoomOut: function(){
                            $(this).trigger('zoom.destroy');
                        }
                    });
                },

                moveThumbs: function(direction) {
                    let len = this.thumbs.length;

                    if (direction === "top") {
                        const moveThumb = this.thumbs.splice(len - 1, 1);

                        this.thumbs = [moveThumb[0]].concat((this.thumbs));

                        this.counter.up = this.counter.up+1;

                        this.counter.down = this.counter.down-1;

                    } else {
                        const moveThumb = this.thumbs.splice(0, 1);

                        this.thumbs = [].concat((this.thumbs), [moveThumb[0]]);

                        this.counter.down = this.counter.down+1;

                        this.counter.up = this.counter.up-1;
                    }

                    if ((len-4) == this.counter.down) {
                        this.is_move.down = false;
                    } else {
                        this.is_move.down = true;
                    }

                    if ((len-4) == this.counter.up) {
                        this.is_move.up = false;
                    } else {
                        this.is_move.up = true;
                    }
                },
            }
        });

    </script>

    <script>
        $(document).ready(function() {
            $('#myTab2').slick({
                dots: false,
                arrows: true,
                infinite: false,
                vertical: true,
                speed: 300,
                prevArrow: '<button type="button" class="slick-prev"><i class="fas fa-arrow-up"></i></button>',
                nextArrow: '<button type="button" class="slick-next"><i class="fas fa-arrow-down"></i></button>',
                slidesToShow: 3,
                slidesToScroll: 1,
                responsive: [
                    {
                        breakpoint: 768,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
        });
    </script>

@endpush