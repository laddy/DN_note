<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="utf-8">

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
<div class="container">
<a class="brand" href="<?=site_url('/')?>">DN note</a>

</div>
</div>
</div>
<!-- end navi -->


<div class="container">


<!-- start header -->
<header>
<div class="head_img" style="width:940px; height:200px; background-image: url('img/top_img.jpg')">
<h1>DN note</h1>
<p>DN noteへようこそ</p>
<p>This is a template for a simple marketing or informational website.</p>
</div>
</header>
<!-- end header -->

<form class="well form-inline" action="<?=site_url('/');?>auth/" method="post">
ユーザ名: <input type="text" name="login" placeholder="ID" required>
パスワード: <input type="password" name="pass" placeholder="Password" required>
<input value="ログイン" type="submit" class="btn btn-primary" />


<?php /*
<select id="fc_select" name="">
<option value="">所属施設を選択してください</option>
<? foreach ( $fc as $f ) : ?>
<option value="<?=$f['id']?>"><?=$f['name']?></option>
<? endforeach; ?>
</select>
<p id="user_select"></p>

<p id="input_pass" style="display:none;">
パスワード: <input type="password" />
</p>

*/ ?>
</form>

<? var_dump($this->session->all_userdata()); ?>

<footer>
<p>&copy; YuyaTanaka</p>
</footer>

</div>


<script>

// selectを選択すると外部スクリプトにgetを投げて値取得
$("#fc_select").change(function () {
  // alert($("#fc_select").val()),
  var item = '' ;

  $.get("<?=base_url('/')?>",
    {fc: $("#fc_select").val()},
    function(data) {
      $("#user_select").empty();
      for(var i in data) {
        $("#user_select").append('<span class="push_user">'+data[i].id + data[i].name+'</span>');
      }
    },
    'json'
  );
});

$(".push_user").live('click', function () {
    $("#input_pass").hide("fast");
    $("#input_pass").show("fast");
});

</script>

</body>
</html>
