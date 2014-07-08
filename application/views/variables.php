<div>

	<form method="get" action="<?php echo base_url();?>dashboard/receiveInputs">
		Initial Minutes Shift: <input type="number" name="initialMinutes" value="<?php if(isset($initialTimeShift)) echo $initialTimeShift;?>"><br />
		Minutes Shift: <input type="number" name="Minutes" value="<?php if(isset($endTimeShift)) echo $endTimeShift;?>"><br />
		N Value: <input type="number" name="nValue" value="<?php if(isset($nValue)) echo $nValue;?>"><br />
		<input type="submit" value="Calc Average"/>
	</form>

</div>
