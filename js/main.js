/**---------------------------------------------------------------
 * 変数定義
--------------------------------------------------------------- */

var searchItem = '.search_item';   // 絞り込む項目を選択するエリア
var listItem = '.list_item';       // 絞り込み対象のアイテム
var hideClass = 'is-hide';         // 絞り込み対象外の場合に付与されるclass名
var activeClass = 'is-active';     // 選択中のグループに付与されるclass名



/**---------------------------------------------------------------
 * 検索イベント
--------------------------------------------------------------- */


//種類別検索-------------------------------------------------------------

// let group = "";

$(function() {
  $("#find").change(function() {
    $(searchItem).removeClass(activeClass);
    group = $('option:selected').addClass(activeClass).data('group');
    search_filter(group);
  });
});

/**
 * リストの絞り込みを行う
 * @param {String} group data属性の値
 */

function search_filter(group) {
  // console.log(group);
  // 非表示状態を解除
  $('.is-hide').removeClass(hideClass);
  // 値が空の場合はすべて表示
  if(group === '') {
    return;
  }
  // リスト内の各アイテムをチェック
  for (var i = 0; i < $(listItem).length; i++) {
    // アイテムに設定している項目を取得
    var itemData = $(listItem).eq(i).data('group');
    // 絞り込み対象かどうかを調べる
    if(itemData !== group) {
      $(listItem).eq(i).addClass(hideClass);
    }
  }
}

//種類別検索-------------------------------------------------------------

$(function() {
  const $searchInput = $('#search-text'); // 入力エリア
  let $searchElem  = $('.list_item');// 絞り込む要素
  let hideClass = 'is-hide';  // 絞り込み対象外の要素に付与するclass

  // 絞り込み処理
  function extraction() {
      let keywordArr = $searchInput.val().toLowerCase().replace('　', ' ').split(' '); // 入力文字列を配列に格納
      $searchElem.removeClass(hideClass).show();// 現在非表示にしているリストを表示する
      for (let i = 0; i < keywordArr.length; i++) {
          for (let j = 0; j < $searchElem.length; j++) {
              let thisString = $searchElem.eq(j).text().toLowerCase();

              // console.log(item_group,item_num);
              if(thisString.indexOf(keywordArr[i]) == -1) { // 入力文字列と一致する文字列がない場合
                $(listItem).eq(j).addClass(hideClass); // 絞り込み対象外のclass付与
              }
          }
      }
      // $('.' + hideClass).hide(); // 絞り込み対象外の要素の非表示
  }

  $searchInput.on('load keyup blur', function() {
      extraction();
  });
});


//input入力半角英数字-------------------------------------------------------------

$(document).on('keydown', '.input_alphanumeric', function(e){
  let k = e.keyCode;
  let str = String.fromCharCode(k);
  if(!(str.match(/[0-9a-zA-Z]/)) || e.shiftKey || (37 <= k && k <= 40) || k === 8 || k === 46){
    return false;
  }
});

$(document).on('keyup', '.input_alphanumeric', function(e){
  if(e.keyCode === 9 || e.keyCode === 16) return;
  this.value = this.value.replace(/[^0-9a-zA-Z]+/i,'');
});

$(document).on('blur', '.input_alphanumeric',function(){
  this.value = this.value.replace(/[^0-9a-zA-Z]+/i,'');
});

//種類別検索-------------------------------------------------------------

//種類別検索-------------------------------------------------------------

$(document).on('click', '#customInfobox', function(){
  let infoboxTemplate =   `<div class="modal-content" id="modal-content">
                              <div class="topline">
                                  <div class="username" id="username">${username}</div>
                                  <div class="age" id="age">${age}</div>
                              </div>
                              <div class="title" id="title">${title}</div>
                              <div class="contents" id="contents">${contents}</div>
                              <input type="button" class="videogo" id="videogo" value="ビデオ通話する">
                              <input type="button" class="modal-close" id="modal-close" value="閉じる">
                          </div>`;
  // console.log(infoboxTemplate);

  $('main').append(infoboxTemplate);

  $('#videogo').on('click',function(){


      $('#modal-content,#modal-overlay').fadeOut('solw', function(){

          // #modal-overlayを削除する
          $('#modal-content,#modal-overlay').remove();
      });
  })

  //キーボード操作などにより、オーバーレイが多重起動するのを防止
  $(this).blur();
  if($('#modal-overlay')[0]) return false; //新しくモーダルウィンドウを起動しない (防止策1)

  //オーバーレイを出現させる
  $('main').append( '<div class="modal-overlay" id="modal-overlay"</div>' );
  $('#modal-overlay').fadeIn('slow');

  centeringModalSyncers()

  //コンテンツをフェードインする
  $('#modal-content').fadeIn('slow');

  // #modal-content,#modal-overlayをクリックして
  $('#modal-close,#modal-overlay').unbind().click(function(){

      // #modal-content,#modal-overlayをフェードアウトして
      $('#modal-content,#modal-overlay').fadeOut('solw', function(){

          // #modal-overlayを削除する
          $('#modal-content,#modal-overlay').remove();
      });
  });

  // const target = document.getElementById('videogo');
  // target.href = "vdsk.html"

  // $('#videogo').on('click', function(target){
  //      window.location.href = "vdsk.html";
  // });


  //リサイズされたら、センタリングをする関数[centeringModalSyncer()]を実行する
  $(window).resize(centeringModalSyncers);

  // センタリングを実行する関数
  function centeringModalSyncers(){

      // 画面（ウィンドウ）の幅、高さを取得
      let w = $(window).width();
      let h = $(window).height();

      // コンテンツ(#modal-content)の幅、高さを取得
      let cw = $("#modal-content").outerWidth();
      let ch = $("#modal-content").outerHeight();

　　　　　// （ウィンドウ）から(#modal-content)を引いたあまりの余白を2で割りセンタリングを実行する
      $("#modal-content").css({ "left": ( (w - cw) /2 ) + "px", "top": ( ( h - ch ) /2 ) +"px" } );
  }
});
