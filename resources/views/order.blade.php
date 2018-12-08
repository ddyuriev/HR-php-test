<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Edit Order</title>
    <link rel="stylesheet" href="/css/app.css">
    <link rel="stylesheet" href="/css/style.css">
    <script src="/js/app.js"></script>
    <script src="/js/script.js"></script>
</head>
<body>

<form id="order" method="post" class="col-lg-4 col-md-4 col-sm-12" action={{URL::to('/orders')}} >
    {{ csrf_field() }}
    <div class="form-group">
        <input type="hidden" class="form-control" name="id" value={{ $order->id }}>
    </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon" id="email">email клиента</span>
            <input type="text" class="form-control" name="email" placeholder="email клиента" required
                   aria-describedby="email" value={{$order->client_email}} >
        </div>
    </div>

    <div class="form-group">
        <div class="btn-group select">
            <button type="button" class="btn btn-default" id="partner-name">{{$order->partner->name}}</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                <span class="caret"></span>
                <span>Партнер</span>
            </button>
            <ul class="dropdown-menu partners-dropdown">
                @foreach ($partners as $partner)
                    <li id="li-{{$partner->id}}" onclick="$('#partner').val({{$partner->id}})">
                        <a href="#">{{$partner->name}}</a>
                    </li>
                @endforeach
            </ul>
            <input id="partner" type="hidden" class="form-control" name="partner" value={{ $order->partner->id }}>
        </div>
    </div>

    <div class="tab-pane active" id="products" role="tabpanel" aria-labelledby="pills-current-tab">
        <table class="table">
            <thead>
            <tr>
                <th scope="col">Товар</th>
                <th scope="col">Количество</th>
            </tr>
            </thead>
            <tbody>
            @foreach ($order->order_products as $orderProducts)
                <tr>
                    <td scope="row">{{ $orderProducts->product->name }}</td>
                    <td>
                        <div class="input-group input-group-sm">
                            <span class="input-group-addon" id="sizing-addon3"></span>
                            <input type="number" pattern="[0-9]" min="0" class="form-control" placeholder="кол-во"
                                   id="product-{{$orderProducts->product_id }}"
                                   name="product-{{ $orderProducts->product_id }}" aria-describedby="sizing-addon3"
                                   value={{ $orderProducts->quantity }}>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    <div class="form-group">
        <div class="btn-group select">
            <button type="button" class="btn btn-default" id="status-name">{{$order->statusName}}</button>
            <button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown"
                    aria-haspopup="true"
                    aria-expanded="false">
                <span class="caret"></span>
                <span>Статус</span>
            </button>
            <ul class="dropdown-menu status-dropdown">
                @foreach ($statuses as $key => $status)
                    <li id="li-status-{{$key}}" onclick="$('#status').val({{$key}})">
                        <a href="#">{{$status}}</a>
                    </li>
                @endforeach
            </ul>
            <input id="status" type="hidden" class="form-control" name="status" value={{$order->status }}>
        </div>
    </div>

    <div class="form-group">
        <div class="input-group">
            <span class="input-group-addon">стоимость заказа</span>
            <input type="text" id="ordercost" class="form-control" placeholder="стоимость заказа" required
                   aria-describedby="ordercost" value={{$order->ordercost}} readonly>
        </div>
    </div>

    <div class="btn-group">
        <button type="submit" class="btn btn-default">сохранить</button>
    </div>
</form>

</body>
</html>
