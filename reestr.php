<?php
 session_start();
 $token= md5(uniqid());
 $_SESSION['customer_token']= $token;
 session_write_close();
?>
<!--noindex-->
<form id='SearchRegistry' method='post' accept-charset='UTF-8'>
<fieldset >
<legend>������ �������� ������������</legend>

<div class='container'>
<input type="hidden" name="token" value="<?php echo $token; ?>" required />
<label for='name' style="width:168px;display: inline-block;"><strong>�������� �����������:</strong> </label><select type="text" name="" id="napravlenie" maxlength="50">
   <option value="1" selected="">�������� ��������</option>
</select>
<label for='name' style="width:168px;display: inline-block;"><strong>�������:</strong> </label><input class="ui-widget ui-state-default ui-corner-all" type='text' name='name' id='name' maxlength="50" required />
<label for='number' style="width:168px;display: inline-block;" ><strong>����� �����������:</strong></label><input class="ui-widget ui-state-default ui-corner-all"  type='text' name='number' id='number' maxlength="50" required/>
<!--<label for='date' >���� ������: </label><br/>
<input type='text' name='date' id='sdate'/><br/>
<label for='area' >������� ����������: </label><br/>
<input type='text' name='area' id='area'/><br/>
<label for='organization' >�����������: </label><br/>
<input type='text' name='organization' id='organization'/>-->
</div>
<br/>
<div class='container' style="margin-top:25px;">
<input type='submit' name='Submit' value='�����' class="button green" />
</div>
<div class="putreswrap">
<br>
<div class="put_results">
</div>
</div>
</fieldset>
</form>
<!--/noindex-->