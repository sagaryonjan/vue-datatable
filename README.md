# Laravel Vue Js Datatable.

The `sagaryonjan/vue-datatable` package provides easy to create table with vue js. It makes easy to customize your table.

## Installation

You can install the package via composer:

``` bash
composer require sagaryonjan/vue-datatable
```

The package will automatically register itself.

You can publish the migration with:
```bash
php artisan vendor:publish --tag="vue-datatable"
```

Register Vue-datable in resources app.js
``` bash
Vue.component('data-table', require('./components/datatable/DataTable.vue'));

```

Create Route
``` bash
DataTable::routes('category', 'CategoryController')->only('index');

```

Create Datatable Controller.
``` bash
php artisan datatable:controller CategoryController App\Model\Category
```

View Table
``` bash
{!! DataTable::render('category') !!}
```



## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
