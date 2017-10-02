<template>

    <div class="panel panel-default">
        <div class="panel-heading">{{ response.table }}</div>

        <div class="panel-body">

            <div class="row">

                <div v-if="response.quick_search"
                     :class="{
                         'form-group col-md-12':pagination.total < pagination.perPage,
                         'form-group col-md-10':pagination.total > pagination.perPage }">
                    <label for = "filter">Quick Search Current Results</label>
                    <input type="text" id="filter" @keyup='instantSearch'  class="form-control" v-model="quickSearchQuery">
                </div>

                <div class="form-group col-md-2" v-if="pagination.total > pagination.perPage">

                    <label for="limit"> Display Records </label>
                        <select id="limit" class="form-control" v-model="limit" @change="getLimitRecords">
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="1000">1000</option>
                            <option value=" ">All</option>
                        </select>
                </div>

            </div>

            <div class="table-responsive">
               <table class="table table-striped" >
                    <thead>
                        <tr>
                            <th v-for="column in response.displayable">
                            <span class="sortable" @click="sortBy(column)">{{ column | capitalize }}</span>

                           <div class="arrow"
                           v-if="sort.key === column"
                           :class="{ 'arrow--asc': sort.order === 'asc', 'arrow--desc': sort.order === 'desc' }"
                           ></div>
                            </th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="record in filteredRecords">
                            <td v-for="columnValue, column in record">

                                <template v-if="editing.id === record.id && isUpdateAble(column)">

                                    <div class="form-group" :class="{ 'has-error' : editing.errors[column] }">
                                         <input type="text" class="form-control" :value="columnValue" v-model="editing.form[column]">

                                          <span class="help-block" v-if="editing.errors[column]">
                                             <strong>
                                             {{ editing.errors[column][0] }}
                                             </strong>
                                          </span>
                                    </div>

                                </template>


                                <template v-else >

                                        <template v-if="Object.values(response.custom_column).indexOf(column) > -1">

                                            <div v-html="columnValue"></div>

                                        </template>

                                        <template v-else >

                                            {{ columnValue }}

                                        </template>

                                </template>

                            </td>

                        </tr>
                    </tbody>
               </table>

                <vue-pagination v-if="pagination.total > pagination.perPage"
                        v-bind:pagination="pagination"
                                 v-on:click.native="getRecords()"
                                 :offset="4">
                </vue-pagination>
            </div>
        </div>
    </div>

</template>

<script>

    import queryString from 'query-string'

    export default {

        props: ['endpoint'],


        data() {
            return {
                response : {
                    displayable: [],
                    records: [],
                    table: [],
                    quick_search: false,
                    custom_column: []
                },
                sort: {
                   key: 'id',
                   order: 'asc'
                },
                limit: 50,
                quickSearchQuery:'',
                editing: {
                    id: null,
                    form: {},
                    errors: []
                },
                pagination: {
                    total: 0,
                    perPage: 2,
                    firstItem: 1,
                    lastItem: 0,
                    currentPage: 1
                },
                offset: 4,
            }

        },
        filters: {
            capitalize: function (value) {

                if (!value) return '';

                var stringValue = value.toString();

                var new_value = stringValue.replace('-',' ').replace('_', ' ');

                return new_value.charAt(0).toUpperCase() + new_value.slice(1).toLowerCase();
            }
        },

        computed: {


            filteredRecords() {

                // assigning data with response records
                let data  = this.response.records

                // sorting keys with loads orderBy
                if(this.sort.key) {
                    data = _.orderBy(data, (i) => {
                        let value = i[this.sort.key]

                        if(!isNaN(parseFloat(value))) {
                            return parseFloat(value)
                        }

                        return String(i[this.sort.key]).toLowerCase()
                    },this.sort.order)
                }


              return data
            },
        },
        methods: {

            instantSearch()
            {
                return this.getRecords();
            },
            getLimitRecords()
            {
               return this.getRecords('limit');
            },
            getRecords(param = null) {
                return axios.get(`${this.endpoint}?${this.getQueryParameters(param)}`).then((response) => {
                    this.response  = response.data.data
                    this.pagination  = response.data.data.paginate

                })
            },
            getQueryParameters(param = null) {

                var page = this.pagination.currentPage;

                if(param == 'limit') {
                    page = 1
                }

                return queryString.stringify({
                    page: page,
                    limit: this.limit,
                    quick_search: this.quickSearchQuery
                })


            },
            sortBy(column) {
                this.sort.key  = column
                this.sort.order = this.sort.order === 'asc'?'desc':'asc';
            },
            edit (record) {
                this.editing.errors = []
                this.editing.id = record.id
                this.editing.form =_.pick(record, this.response.updateable)
            },
            isUpdateAble( column ) {

                return this.response.updateable.includes(column)

            },
            update() {

                axios.patch(`${this.endpoint}/${this.editing.id}`, this.editing.form).then( (response) => {
                    this.getRecords().then( () => {
                        this.editing.id = null
                        this.editing.form = {}
                    })
                }).catch((error) => {
                 this.editing.errors = error.response.data.errors
                })


            },

        },
        mounted() {

            this.getRecords();

        },
    }
</script>

<style lang="scss">
.sortable {
    cursor: pointer
}

.arrow {
    display : inline-block;
    vertical-align: middle;
    width:0;
    height:0;
    margin-left:5px;
    opacity: .6;

    &--asc {
        border-left:4px solid transparent;
        border-right:4px solid transparent;
        border-bottom:4px solid #222;
    }

    &--desc {
            border-left:4px solid transparent;
            border-right:4px solid transparent;
            border-top:4px solid #222;
        }
}

</style>
