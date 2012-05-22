<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="れんらくのーと">
<meta name="author" content="Yuya Tanaka">

<title>DN note</title>
<link href="<?=site_url('/')?>css/bootstrap.css" rel="stylesheet">
<link href="<?=site_url('/')?>css/bootstrap-responsive.css" rel="stylesheet">
<script src="<?=base_url('/')?>js/jquery-1.7.1.min.js"></script>
<script src="<?=site_url('/')?>js/bootstrap.js"></script>

</head>
<body>
<!-- start navi -->
<div class="navbar">
<div class="navbar-inner">
<div class="container-fluid">
<h1><a class="brand" href="<?=site_url('/')?>">DN note</a></h1>
<i class="icon-time"></i><?=$this->session->userdata('name')?>

<ul class="nav pull-right">
<li class="dropdown">
<a href="#" class="dropdown-toggle" data-toggle="dropdown">
設定
<b class="caret"></b>
</a>
<ul class="dropdown-menu">
<li><a href="<?=site_url('/')?>auth/logout/"><i class="icon-time"></i>ログアウト</a></li>
</ul>
</li>
</ul>


</div>
</div>
</div>
<!-- end navi -->


<div class="container-fluid">
<header>
<h2><?=$ct['diary_date']?></h2>
更新日: <?=$ct['update_date']?>
</header>

<div class="row-fluid">
<div class="span6">

<div id="diary-contents">
<? if ( !empty($ct['diary']) ) : ?>
<?
$own = "";
foreach ( unserialize($ct['diary']) as $d ) :
?>
<p class="user-diary">
<span class="label label-info"> <i class="icon-user"> </i> 名前</span> <?=$d['user_id']?>
<span class="label label-info">
<i class="icon-comment"> </i>
更新日付</span>
<?=$d['date_time']?><br />
<span class="label label-info">
<i class="icon-time"> </i>
連絡事項</span>
<div class="well"><?=$d['diary']?></div><br />
</p>
<? if ( $this->session->userdata('id') === $d['user_id'] ) { $own = $d['diary']; } ?>
<? endforeach; ?>
<? endif; ?>
</div>


<form id="submit_diary">
<textarea id="diary_post" width="100%" height="20"> </textarea>
<a href="javascript:void(0);" id="submit_text" class="btn">送信</a>
</form>

</div>

<div class="span6">
<ul>
<li><img src="">利用者1 2012-02-28</li>
<li><img src="">利用者2 2012-03-28</li>
<li><img src="">利用者3 2012-04-01</li>
</ul>
</div>

</div>
</div>



<footer>
<p>&copy; YuyaTanaka</p>
</footer>

<script type="text/javascript">
var now = '<?=$ct['update_date']?>';

// 投稿を押した場合に反映させる
$("#submit_text").click(function() {
  $("#submit_diary").hide("slow");

  $.post('<?=base_url('/')?>backend/postdiary/', {date: '<?=$ct['diary_date']?>', diary_post: $("#diary_post").val()},
    function(data) {
      $("#diary-contents").hide("slow");
      $("#diary-contents").empty();
      $("#submit_diary").hide("slow");

    /*
      var diaries = eval('('+data+')');

      for ( var i in diaries.diary ) {
        $('#diary-contents').append(
        '<p class="user-diary">id = ' + diaries.diary[i].user_id + 
        '<br />diary = ' + diaries.diary[i].diary + 
        '<br />date_time = ' + diaries.diary[i].date_time+ '</p>');
      }
      $("#diary-contents").show("slow");
      $("#submit_diary").show("slow");
*/
    if ( data != 'true' ) {
        alert('エラーが発生しました、ブラウザを再読み込みしてください');
    }
  });
});

/*
$("#tweetarea").live('focus', function() {
  $("#tweetarea").attr('rows', 3);
  $("#post_submit").show();
});
$("#add_post").live('blur', function() {
  // $("#tweetarea").attr('rows', 1);
  // $("#post").hide();
});
*/


// load auto tweet check
// 一定時間おきに実行 update_date 取得、更新されていないか監視する
<? if ( !empty($ct['diary_date']) ) : ?>
$(function(){
    var timer = 1000;
    var office      = '<?=$this->session->userdata('facility_id')?>';

    setInterval(function() {
    $.post('<?=base_url('/')?>backend/checkts/', {date: '<?=$ct['diary_date']?>', update: '<?=$ct['update_date']?>'}, 
        function(data) {
            var get_json = eval('('+data+')');
            //alert(data);

            if ( String(get_json.newdate) != now )
            {
                now = get_json.newdate;
                $("#diary-contents").hide("slow");
                $("#diary-contents").empty();
                
                for ( var i in get_json.diary ) {
                    $('#diary-contents').append(
                    '<p class="user-diary"><i class="icon-user"></i> id = ' + get_json.diary[i].user_id + 
                    '<br />diary = ' + get_json.diary[i].diary + 
                    '<br />date_time = ' + get_json.diary[i].date_time+ '</p>');
                }

                $("#diary-contents").show("slow");
                $("#submit_diary").show("slow");
            }
        });
    }, timer);
});
<? endif; ?>


</script>

</body>
</html>
