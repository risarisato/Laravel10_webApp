// 読み込まれたら実行
window.onload = function() {
    let steps = document.getElementById('steps');

    Sortable.create(steps, {
        animation: 150,
        handle: '.handle',
        onEnd: function(evt) { // ソート完了時に実行
            let items = steps.querySelectorAll('.step');
            items.forEach(function(item, index) {
                item.querySelector('.step-number').innerHTML = '手順' + (index + 1);
            });

        }
    });
};