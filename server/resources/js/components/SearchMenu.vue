<template>
    <div>
        <div @click="searchForm" class="search-icon">
            <i class="fa fa-search"></i>
        </div>
        <div class="search-section" v-show="search">
            <form action="/keyword_search" method="get" class="search-form">
                <input class="search-keyword" type="text" name="keyword" v-bind:value="keyword" placeholder="検索キーワード" />
            </form>
        </div>
    </div>
</template>
<script>
export default {
    data() {
        return {
            search: false,
            keyword: '',
        }
    },
    methods: {
        searchForm:function() {
            this.search = !this.search;
        }
    }
}
</script>>