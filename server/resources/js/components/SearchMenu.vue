<template>
    <div class="search-form">
        <form action="/keyword_search" method="get">
            <input type="text" name="keyword" v-bind:value="$keyword" placeholder="検索キーワード" />
            <input type="submit" value="検索" />
        </form>
    </div>
</template>
<script>
export default {
    data() {
        return {
        }
    }
}
</script>>