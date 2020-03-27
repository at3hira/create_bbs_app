
$(function () {
	var activeClass = 'active';

	// ハンバーガーボタン
	function hamburgBtn() {
        $('.btn_hamburger').on('click', function(event) {
            $button = $(this);
            event.preventDefault();

            $button.find('a').toggleClass(activeClass); // ハンバーガーボタンのアニメーション
            $button.next().slideToggle(250); // 表示、非表示
        });
    };
	hamburgBtn();

    function accordion(triggerSelector) {
        // 引数で指定したトリガーをクリックしたとき、クリックしたトリガーの次の要素を展開
		$(triggerSelector).on('click', function(event) {
            $trigger = $(triggerSelector);
            event.preventDefault();
 
            $(this).toggleClass(activeClass);
            $(this).next().slideToggle(250);
        });
    };
 
    // 引数でトリガーを指定
    accordion('#category_accordion .category_list');
});

