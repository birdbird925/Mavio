
<div class="row">
    <div class="col-xs-12">
        <ul class="shop-filter shop-filter-right">
            <li class="dropdown">
                <span>
                    @if(Request::input('sort') == 'recent')
                        Most Recent
                    @elseif(Request::input('sort') == 'cheapest')
                        Price (Low to Hight)
                    @elseif(Request::input('sort') == 'expensive')
                        Price (Hight to Low)
                    @else
                        Sort By
                    @endif
                </span>
                <ul class=menu>
                    {{-- <li class="sortby" data-value="popular">Most Popular</li> --}}
                    <li class="sortby"><a href="{{Request::url()}}?sort=recent">Most Recent</a></li>
                    <li class="sortby"><a href="{{Request::url()}}?sort=cheapest">Price (Low to Hight)</a></li>
                    <li class="sortby"><a href="{{Request::url()}}?sort=expensive">Price (Hight to Low)</a></li>
                </ul>
            </li>
        </ul>

        <ul class="shop-filter">
            <li class="title">Shop All ({{$products->count()}})</li>
            <li class="filter-tab">FILTER</li>
        </ul>
        <ul class="shop-filter filter-menu">
            @if($categories->count() > 0)
                <li class="dropdown">
                    <span>Categories</span>
                    <ul class="menu">
                        @foreach($categories as $type)
                        <li>
                            <input type="checkbox" name="categories" value="{{$type->id}}" id="category{{$type->id}}" class="filter">
                            <label for="category{{$type->id}}">{{$type->name}}</label>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            @if($brands->count() > 0)
                <li class="dropdown">
                    <span>Brands</span>
                    <ul class="menu">
                        @foreach($brands as $vendor)
                        <li>
                            <input type="checkbox" name="brands" value="{{$vendor->id}}" id="brand{{$vendor->id}}" class="filter">
                            <label for="brand{{$vendor->id}}">{{$vendor->name}}</label>
                        </li>
                        @endforeach
                    </ul>
                </li>
            @endif
            {{-- <li class="dropdown">
                <span>Price</span>
                <ul class="menu">
                    <li>
                        <input type="checkbox" name="prices" value="below" id="price1" class="price-filter">
                        <label for="price1">Below RM50</label>
                    </li>
                    <li>
                        <input type="checkbox" name="prices" value="between" id="price2" class="price-filter">
                        <label for="price2">Between RM50 - RM150</label>
                    </li>
                    <li>
                        <input type="checkbox" name="prices" value="more" id="price3" class="price-filter">
                        <label for="price3">More than RM150</label>
                    </li>
                </ul>
            </li> --}}
        </ul>
    </div>
</div>
