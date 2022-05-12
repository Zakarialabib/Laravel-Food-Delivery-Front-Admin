<div class="mx-auto flex flex-col justify-center bg-white rounded-2xl shadow-xl shadow-slate-300/60 clickable p-0"
    onclick="quickView('{{ $product->id }}')" style="cursor: pointer;">
    @if (empty($product['image']))
    <img class="aspect-video w-96 rounded-t-2xl object-cover object-center"
    src="{{ asset('storage/app/public/product/' . $product['image'] )}}">
    @else
    <img class="aspect-video w-96 rounded-t-2xl object-cover object-center"
    src="data:image/svg+xml,%3Csvg%20width%3D%22344%22%20height%3D%22194%22%20xmlns%3D%22http%3A%2F%2Fwww.w3.org%2F2000%2Fsvg%22%20xmlns%3Axlink%3D%22http%3A%2F%2Fwww.w3.org%2F1999%2Fxlink%22%3E%3Cdefs%3E%3Cpath%20id%3D%22a%22%20d%3D%22M-1%200h344v194H-1z%22%2F%3E%3C%2Fdefs%3E%3Cg%20transform%3D%22translate(1)%22%20fill%3D%22none%22%20fill-rule%3D%22evenodd%22%3E%3Cmask%20id%3D%22b%22%20fill%3D%22%23fff%22%3E%3Cuse%20xlink%3Ahref%3D%22%23a%22%2F%3E%3C%2Fmask%3E%3Cuse%20fill%3D%22%23BDBDBD%22%20xlink%3Ahref%3D%22%23a%22%2F%3E%3Cg%20mask%3D%22url(%23b)%22%3E%3Cpath%20d%3D%22M173.65%2069.238L198.138%2027%20248%20112.878h-49.3c.008.348.011.697.011%201.046%200%2028.915-23.44%2052.356-52.355%2052.356C117.44%20166.28%2094%20142.84%2094%20113.924c0-28.915%2023.44-52.355%2052.356-52.355%2010%200%2019.347%202.804%2027.294%207.669zm0%200l-25.3%2043.64h50.35c-.361-18.478-10.296-34.61-25.05-43.64z%22%20fill%3D%22%23757575%22%2F%3E%3C%2Fg%3E%3C%2Fg%3E%3C%2Fsvg%3E" >
    @endif
   

    <div class="p-2 clickable">
        <div class="font-medium text-slate-600 pb-2 capitalize">
            {{ Str::limit($product['name'], 15, '...') }}
        </div>
        <div class="justify-content-between text-center">
            <div class="product-price text-center">
                @if ($product->discount > 0)
                    <strike class="text-red-400 text-xs">
                        {{ \App\CentralLogics\Helpers::format_currency($product['price']) }}
                    </strike><br>
                @endif
                <span class="text-lg font-medium text-slate-600 pb-2">
                    {{ \App\CentralLogics\Helpers::format_currency($product['price'] - \App\CentralLogics\Helpers::product_discount_calculate($product, $product['price'], $restaurant)) }}
                </span>
            </div>
        </div>
    </div>
</div>
