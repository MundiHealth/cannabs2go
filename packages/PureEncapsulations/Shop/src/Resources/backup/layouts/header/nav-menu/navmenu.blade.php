{!! view_render_event('bagisto.shop.layout.header.category.before') !!}

<?php

$categories = [];

foreach (app('Webkul\Category\Repositories\CategoryRepository')->getVisibleCategoryTree(core()->getCurrentChannel()->root_category_id) as $category) {
    if ($category->slug)
        array_push($categories, $category);
}

?>

<div> <span>menu</span> </div>
<category-nav categories='@json($categories)' url="{{url()->to('/')}}"></category-nav>

{!! view_render_event('bagisto.shop.layout.header.category.after') !!}


@push('scripts')


<script type="text/x-template" id="category-nav-template">
    <nav id="mobile-menu">
        <ul>
            <li class="active"><a href="/">Home</a></li>
            <li><a href="{{url()->to('/nossos-produtos/produtos?sort=name&order=asc')}}">Produtos</a>
                <i class="fas fa-chevron-down"></i>
                <ul class="sub-menu text-left">
                    <li><a href="{{ route('shop.categories.index', ['mais-vendidos']) }}">Mais Vendidos</a></li>
                    <li><a href="{{url()->to('/nossos-produtos/produtos?sort=name&order=asc')}}">Produtos A-Z</a></li>
                </ul>
            </li>
            <category-item
                v-for="(item, index) in items"
                :key="index"
                :url="url"
                :item="item"
                :parent="index">
            </category-item>
{{--            <li><a href="#">Educação</a>--}}
{{--                <i class="fas fa-chevron-down"></i>--}}
{{--                <ul class="sub-menu text-left">--}}
{{--                    <li><a href="https://www.pureencapsulations.com/education-research/pe-webinar-library" target="_blank">Biblioteca de Webinars</a></li>--}}
{{--                    <li><a href="https://www.pureencapsulations.com/education-research/webinar-calendar" target="_blank">Calendário Webinars</a></li>--}}
{{--                    <li><a href="https://blog.pureencapsulations.com/category/videos-media/" target="_blank">Vídeos e Mídias</a></li>--}}
{{--                    <li><a href="{{url()->to('/institucional/download-de-protocolos')}}">Download de Protocolos</a></li>--}}
{{--                    <li><a href="https://www.pureencapsulations.com/education/download-brochures-and-supporting-materials.html" target="_blank">Download de Materiais Promocionais</a></li>--}}
{{--                </ul>--}}
{{--            </li>--}}
        </ul>
    </nav>

</script>

<script>
    Vue.component('category-nav', {

        template: '#category-nav-template',

        props: {
            categories: {
                type: [Array, String, Object],
                required: false,
                default: (function () {
                    return [];
                })
            },

            url: String
        },

        data: function(){
            return {
                items_count:0
            };
        },

        computed: {
            items: function() {
                return JSON.parse(this.categories)
            }
        },
    });
</script>

<script type="text/x-template" id="category-item-template">
    <li>
        <a :href="url+'/nossos-produtos/'+this.item['translations'][0].slug">
            @{{ name }}&emsp;
        </a>
        <i class="fas fa-chevron-down" v-if="haveChildren && item.parent_id != null"></i>

        <ul class="sub-menu text-left" v-if="haveChildren && show">
            <category-item
                v-for="(child, index) in item.children"
                :key="index"
                :url="url"
                :item="child">
            </category-item>
        </ul>
    </li>
</script>

<script>
    Vue.component('category-item', {

        template: '#category-item-template',

        props: {
            item:  Object,
            url: String,
        },

        data: function() {
            return {
                items_count:0,
                show: false,
            };
        },

        mounted: function() {
            if(window.innerWidth > 319){
                this.show = true;
            }
        },

        computed: {
            haveChildren: function() {
                return this.item.children.length ? true : false;
            },

            name: function() {
                if (this.item.translations && this.item.translations.length) {
                    this.item.translations.forEach(function(translation) {
                        if (translation.locale == document.documentElement.lang)
                            return translation.name;
                    });
                }

                return this.item.name;
            }
        },

        methods: {
            showOrHide: function() {
                this.show = !this.show;
            }
        }
    });
</script>


@endpush