# Laravel Vue Js Datatable.

The `sagaryonjan/vue-datatable` package provides easy to create table with vue js. It makes easy to customize your table.

## Installation

You can install the package via composer:

``` bash
composer require sagaryonjan/vue-datatable
```

You can publish the migration with:
```bash
php artisan vendor:publish --tag="vue-datatable"
```

Register Vue-datable in resources app.js
``` bash
Vue.component('data-table', require('./components/datatable/DataTable.vue'));

```


Create Datatable Controller.
``` bash
php artisan datatable:controller CategoryController App\Model\Category
```

View Table
``` bash
renderDatable($data)
```

Pagination Limit
``` bash
 public $pagination = 20;
```

Show Quick Search default false
``` bash
 protected $quick_search = true;
```

Display column
``` bash
  public $displayColumn = [
        'name',
        'email',
        'full_name',
        'profession',
        'status',
        'action',
    ];
```
Rename Column
``` bash
  public $displayColumn = [
          'name'       => 'Name',
          'email'      => 'Email',
          'full_name'  => 'Full Name',
          'profession' => 'Profession',
          'status'     => 'Status',
          'action'     => 'Action',
      ];
```
   
Customizing Table 
 Let status field be boolean  if you want to show your status active or inactive 
 instead of boolean add this function to your datatable controller 
 
``` bash
public function status($value) {

        if($value->status == 1)
            return "<span class='label label-info'>Active</span>";
        else
            return "<span class='label label-warning'>Warning</span>";

}
```

Using join

``` bash
public function query() {

        $this->query = $this->builder
                            ->select(
                                'users.name',
                                'users.email',
                                'users.status',
                                'user_details.full_name',
                                'user_details.profession'
                            )
                            ->leftjoin(
                                'user_details',
                                'user_details.user_id',
                                '=',
                                'users.id'
                            );
    }
```

Quick Search filter for join
``` bash
  public $quick_search_filter = ['users.name', 'users.email'];
```

Adding Action Column

``` bash
  public function addColumn() {

        $this->add_column = [
            "action" =>[
                'edit' => [
                    "a" =>[
                        'href'      => [ 'route' => 'admin.user.edit', 'param' => ['id'] ],
                        'title'     => 'Edit',
                        'class'     => 'hero starter massive',
                        'id'        => 'stranger-{id}',
                        'data-attr' => 'mistake-{id}'
                    ],
                    "i" => [ 'class' => 'glyphicon glyphicon-edit'],
                ],

                'delete' => [
                    "a" =>[
                        'href'      => [ 'route' => 'admin.user.delete', 'param' => ['id'] ],
                        'title'     => 'Edit',
                        'class'     => 'hero starter massive',
                        'id'        => 'stranger-{id}-{slug}',
                        'data-attr' => 'mistake-{id}'
                    ],
                    "i" => [ 'class' => 'glyphicon glyphicon-trash']
                ]
            ],
        ];
    }
```




## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
