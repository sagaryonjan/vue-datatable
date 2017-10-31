<template>

    <div class="panel panel-default">

        <div class="panel-body">

            <div class="row">

                <div class="form-group col-md-6">
                    <strong>
                        {{ response.paginate_detail.start_from }}
                        -
                        {{ response.paginate_detail.end_to }}
                    </strong> of <strong> {{ response.paginate_detail.total_count }}</strong>
                </div>

                <div v-if="response.quick_search" class="form-group col-md-6">
                    <input type="text" id="filter" @keyup='getRecords' placeholder="Search" class="form-control" v-model="quickSearchQuery">
                </div>

            </div>

            <div class="table-responsive">
               <table class="table table-striped" >
                    <thead>
                        <tr>
                            <th v-for="column in response.displayable">
                                <span >{{ column | capitalize }}</span>
                            </th>
                        </tr>

                    </thead>
                    <tbody>
                        <tr v-for="record in response.records">

                            <td v-for="columnValue, column in record">
                                <div v-html="columnValue"></div>
                            </td>

                        </tr>
                    </tbody>
               </table>

                <pagination v-if="pagination.total > pagination.perPage"
                        v-bind:pagination="pagination"
                                 v-on:click.native="getRecords()"
                                 :offset="4">
                </pagination>
            </div>
        </div>
    </div>

</template>

<script>

    import queryString from 'query-string'

    import Pagination from './Pagination.vue';

    export default {
        components: {
            Pagination
        },
        props: ['endpoint'],

        data() {
            return {
                response : {
                    displayable: [],
                    records: [],
                    table: [],
                    quick_search: false,
                    paginate_detail:{
                        start_from : 0,
                        end_to : 0,
                        total_count : 50
                    }
                },
                quickSearchQuery:'',
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
        methods: {

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
                    limit: this.response.limit,
                    quick_search: this.quickSearchQuery
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
