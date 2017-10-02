<template>
    <ul class="pagination">
        <li v-if="pagination.currentPage > 1">
            <a href="#" aria-label="Previous" v-on:click.prevent="changePage(pagination.currentPage - 1)">
                <span aria-hidden="true">«</span>
            </a>
        </li>
        <li v-for="page in pagesNumber" :class="{'active': page == pagination.currentPage}">
            <a href="#" v-on:click.prevent="changePage(page)">{{ page }}</a>
        </li>
        <li v-if="pagination.currentPage < pagination.lastPage">
            <a href="#" aria-label="Next" v-on:click.prevent="changePage(pagination.currentPage + 1)">
                <span aria-hidden="true">»</span>
            </a>
        </li>
    </ul>
</template>
<script>
    export default{
        props: {
            pagination: {
                type: Object,
                required: true
            },
            offset: {
                type: Number,
                default: 4
            }
        },
        computed: {
            pagesNumber: function () {

                if (!this.pagination.perPage) {
                    return [];
                }

                var from = this.pagination.currentPage - this.offset;

                if (from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2);

                if (to >= this.pagination.lastPage) {
                    to = this.pagination.lastPage;
                }

                var pagesArray = [];

                for (let page = from; page <= to; page++) {
                    pagesArray.push(page);
                }

                return pagesArray;
            }
        },
        methods : {
            changePage: function (page) {
                this.pagination.currentPage = page;
            }
        }
    }
</script>