
// タグをクリックしたらタグ検索ロジックに飛ばす
TagSearchList()
function TagSearchList() {
    $('.clickTagSearchList').on('click', function(e){
        e.stopPropagation();
        e.preventDefault();

        // data-url属性値のURLを取得して遷移させる
        location.href=$(this).attr('data-url');
    });
}