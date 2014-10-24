<?php if($error_message){echo $error_message;}?>
<div class="Box">
<table border="0">
<form method='post' accept-charset="utf-8">
<tr><td><label for="name">氏名：</label></td><td><input type='text' id="name" name='name' maxlength="32"></td></tr>
<tr><td><label for="username">ユーザー名：</label></td><td><input placeholder="4文字以上" type='text' id="username" name='username' maxlength="32"></td></tr>
<tr><td><label for="email">メールアドレス：</label></td><td><input type='text' id="email" name='email' maxlength="80"></td></tr>
<tr><td><label for="password">パスワード：</label></td><td><input placeholder="6文字以上" type='password' id="password" name='password'></td></tr>
<tr><td><input type='submit' value="登録" maxlength="32"></td></tr>
</form>
</table>
</div>