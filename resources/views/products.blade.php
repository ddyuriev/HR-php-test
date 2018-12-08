<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Products</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>
    <script src="/js/script.js"></script>
</head>
<body>

<div id="products" class="col-lg-10 col-md-10 col-sm-12">

    <table class="table">
        <thead>
        <tr>
            <th scope="col">ид_продукта</th>
            <th scope="col">наименование_продукта</th>
            <th scope="col">наименование_поставщика</th>
            <th scope="col">цена</th>
        </tr>
        </thead>
        <tbody>
        @foreach ($products as $product)
            <tr>
                <th scope="row">{{$product->id}}</th>
                <td>{{$product->name}}</td>
                <td>{{$product->vendor->name}}</td>
                <td>
                    <div class="input-group input-group-sm">
                        <span class="input-group-addon" id="sizing-addon3"></span>
                        <input type="number" pattern="[0-9]" min="0" class="form-control" placeholder="цена"
                               id="price-product-{{ $product->id }}"
                               name="price-product-{{ $product->id }}" aria-describedby="sizing-addon3"
                               value={{ $product->price }}>
                    </div>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $products->links() }}
</div>

</body>
</html>
