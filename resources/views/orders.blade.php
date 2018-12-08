<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Orders</title>
    <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
    <link rel="stylesheet" href="/css/app.css">
    <script src="/js/app.js"></script>
</head>
<body>

<div id="orders" class="col-lg-10 col-md-10 col-sm-12">
    <div class="form-group">
    </div>

    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
        <li class="nav-item">
            <a class="nav-link" id="overdue-tab" data-toggle="pill" href="#pills-overdue" role="tab"
               aria-controls="pills-overdue" aria-selected="false">Просроченные</a>
        </li>
        <li class="nav-item active">
            <a class="nav-link active" id="current-tab" data-toggle="pill" href="#pills-current" role="tab"
               aria-controls="pills-current" aria-selected="false">Текущие</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="new-tab" data-toggle="pill" href="#pills-new" role="tab" aria-controls="pills-new"
               aria-selected="false">Новые</a>
        </li>
        <li class="nav-item">
            <a class="nav-link" id="completed-tab" data-toggle="pill" href="#pills-completed" role="tab"
               aria-controls="pills-completed" aria-selected="false">Выполненные</a>
        </li>
    </ul>

    <div class="tab-content" id="pills-tabContent">

        <div class="tab-pane fade" id="pills-overdue" role="tabpanel" aria-labelledby="pills-overdue-tab">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ид_заказа</th>
                    <th scope="col">название_партнера</th>
                    <th scope="col">стоимость_заказа</th>
                    <th scope="col">наименование_состав_заказа</th>
                    <th scope="col">статус_заказа</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders['overdueOrders'] as $order)
                    <tr>
                        <th scope="row"><a href="/orders/{{ $order->id }}/edit" target="_blank">{{ $order->id }}</a></th>
                        <td>{{ $order->partner->name }}</td>
                        <td>{{ $order->ordercost }}</td>
                        <td>{{ $order->productsNames }}</td>
                        <td>{{ $order->statusName }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane active" id="pills-current" role="tabpanel" aria-labelledby="pills-current-tab">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ид_заказа</th>
                    <th scope="col">название_партнера</th>
                    <th scope="col">стоимость_заказа</th>
                    <th scope="col">наименование_состав_заказа</th>
                    <th scope="col">статус_заказа</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders['currentOrders'] as $order)
                    <tr>
                        <th scope="row"><a href="/orders/{{ $order->id }}/edit" target="_blank">{{ $order->id }}</a></th>
                        <td>{{ $order->partner->name }}</td>
                        <td>{{ $order->ordercost }}</td>
                        <td>{{ $order->productsNames }}</td>
                        <td>{{ $order->statusName }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>

        <div class="tab-pane fade" id="pills-new" role="tabpanel" aria-labelledby="pills-new-tab">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ид_заказа</th>
                    <th scope="col">название_партнера</th>
                    <th scope="col">стоимость_заказа</th>
                    <th scope="col">наименование_состав_заказа</th>
                    <th scope="col">статус_заказа</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders['newOrders'] as $order)
                    <tr>
                        <th scope="row"><a href="/orders/{{ $order->id }}/edit" target="_blank">{{ $order->id }}</a></th>
                        <td>{{ $order->partner->name }}</td>
                        <td>{{ $order->ordercost }}</td>
                        <td>{{ $order->productsNames }}</td>
                        <td>{{ $order->statusName }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>


        <div class="tab-pane fade" id="pills-completed" role="tabpanel" aria-labelledby="pills-completed-tab">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ид_заказа</th>
                    <th scope="col">название_партнера</th>
                    <th scope="col">стоимость_заказа</th>
                    <th scope="col">наименование_состав_заказа</th>
                    <th scope="col">статус_заказа</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($orders['completedOrders'] as $order)
                    <tr>
                        <th scope="row"><a href="/orders/{{ $order->id }}/edit" target="_blank">{{ $order->id }}</a></th>
                        <td>{{ $order->partner->name }}</td>
                        <td>{{ $order->ordercost }}</td>
                        <td>{{ $order->productsNames }}</td>
                        <td>{{ $order->statusName }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        </div>
    </div>

</div>
</body>
</html>
