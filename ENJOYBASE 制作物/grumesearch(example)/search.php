<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <link rel ="stylesheet" href="design.css">
    <script src="jaScript.js" type="text/javascript"></script>
    <title>Gourme Search</title>
</head>

<body bgcolor="#EDDDD4">
    <div class="header">
	    <div class="header-logo"><img src="searchpage_photo/グルサーチロゴ.png" alt="グルサーチロゴ" width="150px" height="100px"></div>
	    <div class="header-list">
		    <ul>
			    <li><a href="toppage.php" style="color:azure;text-decoration: none;">サービスについて</a></li>
			    <li><a href="pre_resist.php" class="btn-sticky">新規会員登録</a></li>
			    <li><a href="loginpage.php" class="btn-sticky">ログイン</a></li>
		    </ul>
	    </div>
    </div>
    <div align="center">
    <div style="background: rgb(255, 255, 255); width: 80%; font-size: 100%;">
        <p style="margin-top:100px;">
        <div align="center">
            <h1 id="about" class="text-white"><span class="sample2">お店を探す</span></h1>
            <h3 class="text-white-50">
                下記フォームに検索したい地域とランチorディナーを入力して下さい。<br>
                あなたにぴったりのお店が見つかるはずです。
            </h3>
        </div>  
        </p>
        <div class ="contact-form" align="center">
        <form method ="post" action="">
            <table border="1">
                <tbody>
                    <div class="cp_ipselect">
                        <select name="prefecture" class="cp_sl06" required>
                            <option value="" hidden disabled selected></option>
                            <option value="1">北海道</option><option value="2">青森県</option> <option value="3">岩手県</option>
                            <option value="4">宮城県</option><option value="5">秋田県</option><option value="6">山形県</option>
                            <option value="7">福島県</option><option value="8">茨城県</option><option value="9">栃木県</option>
                            <option value="10">群馬県</option><option value="11">埼玉県</option><option value="12">千葉県</option>
                            <option value="13">東京都</option><option value="14">神奈川県</option><option value="15">新潟県</option>
                            <option value="16">富山県</option><option value="17">石川県</option><option value="18">福井県</option>
                            <option value="19">山梨県</option><option value="20">長野県</option><option value="21">岐阜県</option>
                            <option value="22">静岡県</option><option value="23">愛知県</option><option value="24">三重県</option>
                            <option value="25">滋賀県</option><option value="26">京都府</option><option value="27">大阪府</option>
                            <option value="28">兵庫県</option><option value="29">奈良県</option><option value="30">和歌山県</option>
                            <option value="31">鳥取県</option><option value="32">島根県</option><option value="33">岡山県</option>
                            <option value="34">広島県</option><option value="35">山口県</option><option value="36">徳島県</option>
                            <option value="37">香川県</option><option value="38">愛媛県</option><option value="39">高知県</option>
                            <option value="40">福岡県</option><option value="41">佐賀県</option><option value="42">長崎県</option>
                            <option value="43">熊本県</option><option value="https://tb-220376.tech-base.net/Oita.php">大分県</option><option value="45">宮崎県</option>
                            <option value="46">鹿児島県</option><option value="47">沖縄県</option>
                        </select>
                        <span class="cp_sl06_highlight"></span>
                        <span class="cp_sl06_selectbar"></span>
                        <label class="cp_sl06_selectlabel">都道府県</label>
                    </div>
                    <div class="cp_ipselect">
                        <select class="cp_sl06" required>
                            <option value="" hidden disabled selected></option>
                            <option value="1">LUNCH</option><option value="2">DINNER</option>
                        </select>
                        <span class="cp_sl06_highlight"></span>
                        <span class="cp_sl06_selectbar"></span>
                        <label class="cp_sl06_selectlabel">lunch or dinner</label>
                    </div>    
                </tbody>
            </table>
            <input type=button onClick="top.location.href=prefecture.value" value="検索" class="btn-gradient-radius">
        </from>
    </div>
    </div>
    <img src="searchpage_photo/うに.jpg" width="425px" height="250px">
    <img src="searchpage_photo/シロクマ.jpg" width="425px" height="250px">
    <img src="searchpage_photo/たんと1.jpg" width="425px" height="250px">
<?php
?>
</body>
</html>