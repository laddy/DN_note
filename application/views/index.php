<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">
<title></title>

<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="description" content="れんらくのーと">
<meta name="author" content="Yuya Tanaka">

<link href="<?=site_url('/')?>css/bootstrap.min.css" rel="stylesheet">
<style type="text/css">
body {
  padding-top: 60px;
  padding-bottom: 40px;
}
</style>
<!-- <link href="<?=site_url('/')?>css/bootstrap-responsive.css" rel="stylesheet"> -->

<script src="<?=site_url('/')?>js/jquery-1.7.1.min.js"></script>
<script src="<?=site_url('/')?>js/bootstrap.min.js"></script>

</head>

<body>
<div class="container-fluid">
<div class="row-fluid">

<div class="span8">
<h2><?=$ct['diary_date']?></h2>
rsegment3 = <?=$this->uri->rsegments[3]?><br />
rsegment4 = <?=$this->uri->rsegments[4]?><br />
    
<?=$ct['diary'];?>

<form id="submit_diary">
<textarea width="100%" height="10">
</textarea>
<a href="javascript:void(0);" id="submit_text" class="btn">送信</a>
</form>

</div>

<div class="span4">
<ul>
<li><img src="" height="120" width="120" />利用者1 2012-02-28</li>
<li><img src="" height="120" width="120" />利用者2 2012-03-28</li>
<li><img src="" height="120" width="120" />利用者3 2012-04-01</li>
</ul>
</div>

</div>
</div>
    

<script type="text/javascript">
// 投稿を押した場合に反映させる
$("#submit_text").click(function() {
  $("#submit_diary").hide("slow");

  $.post('<?=base_url('/')?>contact/postdate/<?=$this->uri->rsegments[3]?>/<?=$this->uri->rsegments[4]?>/',
    function(data) {
      $("#main_form").remove();
      $('#hoge').after('<div id="main_form" class="alert alert-info alert-block"><h4 class="alert-heading">新規発言が</h4></div>');
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
<? if ( !empty($this->uri->rsegments[3]) ) : ?>
$(function(){
    var timer = 5000;
    var office      = '<?=$this->uri->rsegments[3]?>';
    var date_target = '<?=$this->uri->rsegments[4]?>';
    var now = '<?=$ct['update_date']?>';

    setInterval(function() {
    $.get('<?=base_url('/')?>contact/checkts/<?=$this->uri->rsegments[3]?>/<?=$this->uri->rsegments[4]?>/', 
        function(data) {
            if ( data != now )
            {
                alert('now='+now+' data='+data);
                now = data;
                $("#main_form").remove();
                $('#hoge').after('<div id="main_form" class="alert alert-info alert-block"><h4 class="alert-heading">新規発言が</h4></div>');
            }
        });
    }, timer);
});
<? endif; ?>


</script>

</body>
</html>
