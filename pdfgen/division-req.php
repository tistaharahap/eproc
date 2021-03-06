<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd"><html xmlns="http://www.w3.org/1999/xhtml"><head><meta http-equiv="Content-Type" content="text/html; charset=utf-8" /><link href="/themes/default/style.css" rel="stylesheet" type="text/css"><link href="/themes/default/pdf.css" rel="stylesheet" type="text/css"></head><body style="background: none;">
<?php
	
	include "DbConnector.class.php";
	include "../inc/functions.inc.php";
	$conn = new DbConnector();
	
	$q = "SELECT * FROM ep_tender_requests WHERE tender_id = $_GET[tender_id] LIMIT 1";
	$r = $conn->fetchArray($conn->query($q));
	foreach($r as $key => $value) {
		if($key == 'req_type') { $value = strtoupper($value); }
		if($key == 'user_id') { $value = getFullNameByIdDiv($value); }
		$tender[$key] = $value;
	}
	
	$q = "SELECT * FROM ep_tender_items WHERE tender_id = $_GET[tender_id] ORDER BY item_id";
	$t = $conn->query($q); $i = 0;
	while($s = $conn->fetchArray($t)) {
		foreach($s as $key => $value) {
			if($key == 'req_date') { $holder[$key][$i] = date("d M y", $value); }
			else if($key == 'req_currency') { $holder[$key][$i] = strtoupper($value); }
			else if($key == 'req_est_price') {
				$holder[$key][$i] = numberFormat($value);
			}
			else { $holder[$key][$i] = $value; }
		}
		$i++;
	}
	
	$conn->close();
?><table width="100%" border="0" cellspacing="0" cellpadding="0" style="font-size: 9pt;">
      <tr>
        <td width="50%" valign="top" class="tdBorder" style="border-right: 0;">
            <img src="/themes/default/images/pertagas-logo.jpg" alt="Pertagas" border="0" />       </td>
        <td width="50%" valign="top" class="tdBorder" style="border-left: 0;">
        </td>
      </tr>
      <tr>
        <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td colspan="4" valign="top" class="tdBorder" style="border-top: 0; border-right: 0; font-size: 13pt; font-weight: bold;"><?= strtoupper($tender[req_type]); ?> REQUISITION - <?= $tender[req_mrsr_number]; ?></td>
            <td width="9%" valign="top" class="tdBorder" style="border-left: 0; border-top: 0; border-right: 0;">
                Purposes:</td>
            <td width="47%" valign="top" class="tdBorder" style="border-top: 0; border-left: 0;"><?= $tender[req_purpose] ?></td>
          </tr>
          <tr>
            <td width="4%" valign="top" class="tdBorder" style="border-top: 0; border-right: 0;">From</td>
            <td width="19%" valign="top" class="tdBorder" style="border-left: 0; border-top: 0;"><?= $tender[req_from] ?></td>
            <td width="3%" valign="top" class="tdBorder" style="border-top: 0; border-left: 0; border-right: 0;">To</td>
            <td width="18%" valign="top" class="tdBorder" style="border-top: 0;"><?= $tender[req_to] ?></td>
            <td colspan="2" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="19%" class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0; padding-bottom: 0;">Kode Pembebanan</td>
                <td width="23%" class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0; padding-bottom: 0;">G/L No.</td>
                <td width="21%" class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0; padding-bottom: 0;">Cost Center</td>
                <td width="20%" class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0; padding-bottom: 0;">Project</td>
                <td width="17%" class="tdBorder" style="border-left: 0; border-top: 0; border-bottom: 0; padding-bottom: 0;">Internal Order</td>
              </tr>
              <tr>
                <td class="tdBorder" style="border-left: 0; border-top: 0; border-right: 0; border-bottom: 0;"><label>
                  <?= $tender[req_kode_pembebanan] ?>
                </label></td>
                <td class="tdBorder" style="border-left: 0; border-top: 0; border-right: 0; border-bottom: 0;"><?= $tender[req_gl_no] ?></td>
                <td rowspan="3" valign="top" class="tdBorder" style="border-right: 0; border-left: 0; border-top: 0;">
                  <?= $tender[req_cost_center] ?>
                </td>
                <td rowspan="3" valign="top" class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0;"><?= $tender[req_project] ?></td>
                <td rowspan="3" valign="top" class="tdBorder" style="border-left: 0; border-top: 0;"><?= $tender[req_internal_order] ?></td>
              </tr>
              <tr>
                <td class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0; padding-bottom: 0;">P Group</td>
                <td class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0; border-bottom: 0; padding-bottom: 0;">Bayer</td>
                </tr>
              <tr>
                <td class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0;"><?= $tender[req_pgroup] ?></td>
                <td class="tdBorder" style="border-left: 0; border-right: 0; border-top: 0;"><?= $tender[req_bayer] ?></td>
                </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="6" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <table id="reqFldTbl" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td width="3%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">No</div></td>
                <td width="26%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Description</div></td>
                <td width="9%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Quantity</div></td>
                <td width="6%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">UoM</div></td>
                <td width="11%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Required Date</div></td>
                <td width="13%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Material Group</div></td>
                <td width="23%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Estimated Price/Unit</div></td>
                <td width="4%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Currency</div></td>
                <td width="5%" class="tdBorder" style="border-top: 0;"></td>
              </tr>
              <?php
			  	$counter = count($holder[req_desc]);
				for($i = 0; $i < $counter; $i++) {
				//for($i = 0; $i < 60; $i++) {
					if($i == 26) {
			  ?>
			  <tr>
			  	<td colspan="9">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td colspan="9">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td colspan="9">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td colspan="9" class="bottomBorder">
					<p><img src="/themes/default/images/pertagas-logo.jpg" alt="Pertagas" border="0" /></p>
					<p>&nbsp;</p>
				</td>
			  </tr>
			  <tr>
			  	<td width="3%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">No</div></td>
                <td width="26%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Description</div></td>
                <td width="9%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Quantity</div></td>
                <td width="6%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">UoM</div></td>
                <td width="11%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Required Date</div></td>
                <td width="13%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Material Group</div></td>
                <td width="23%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Estimated Price/Unit</div></td>
                <td width="4%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Currency</div></td>
                <td width="5%" class="tdBorder" style="border-top: 0;"></td>
			  </tr>
			  <?php } else if($i == 57) { ?>
			  <tr>
			  	<td colspan="9">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td colspan="9" class="bottomBorder">
					<p><img src="/themes/default/images/pertagas-logo.jpg" alt="Pertagas" border="0" /></p>
					<p>&nbsp;</p>
				</td>
			  </tr>
			  <tr>
			  	<td width="3%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">No</div></td>
                <td width="26%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Description</div></td>
                <td width="9%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Quantity</div></td>
                <td width="6%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">UoM</div></td>
                <td width="11%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Required Date</div></td>
                <td width="13%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Material Group</div></td>
                <td width="23%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Estimated Price/Unit</div></td>
                <td width="4%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Currency</div></td>
                <td width="5%" class="tdBorder" style="border-top: 0;"></td>
			  </tr>
			  <?php }  else if($i == 88) { ?>
			  <tr>
			  	<td colspan="9">&nbsp;</td>
			  </tr>
			  <tr>
			  	<td colspan="9" class="bottomBorder">
					<p><img src="/themes/default/images/pertagas-logo.jpg" alt="Pertagas" border="0" /></p>
					<p>&nbsp;</p>
				</td>
			  </tr>
			  <tr>
			  	<td width="3%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">No</div></td>
                <td width="26%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Description</div></td>
                <td width="9%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Quantity</div></td>
                <td width="6%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">UoM</div></td>
                <td width="11%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Required Date</div></td>
                <td width="13%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Material Group</div></td>
                <td width="23%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Estimated Price/Unit</div></td>
                <td width="4%" class="tdBorder" style="border-top: 0; border-right: 0;"><div align="center">Currency</div></td>
                <td width="5%" class="tdBorder" style="border-top: 0;"></td>
			  </tr>
			  <?php } ?>
              <tr>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;"><?= $i+1 ?></td>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;" align="center">
                	<?= $holder[req_desc][$i] ?>                </td>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;" align="center">
                	<?= $holder[req_qty][$i] ?>                </td>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;" align="center">
                	<?= $holder[req_uom][$i] ?>                </td>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;" align="center">
                	<?= $holder[req_date][$i] ?>                </td>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;" align="center">
                	<?= $holder[req_material_group][$i] ?>                </td>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;" align="center">
                	<?= $holder[req_est_price][$i] ?>                </td>
                <td valign="top" class="tdBorder" style="border-top: 0; border-right: 0;">
                	<?= $holder[req_currency][$i] ?>                </td>
                <td valign="top" class="tdBorder" style="border-top: 0;">&nbsp;</td>
              </tr>
              <?php
              	}
			  ?>
              </table>
            </table></td>
          </tr>
          <tr>
            <td colspan="4" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="6%" valign="top" style="padding: 7px;">&nbsp;</td>
                <td width="94%" valign="top" style="padding: 7px;">&nbsp;</td>
              </tr>
              <tr>
                <td width="6%" valign="top" class="tdBorder">Remarks</td>
                <td width="94%" valign="top" class="tdBorder" style="border-left: 0;"><?= $tender[req_remarks] ?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="4" valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td colspan="4" valign="top">&nbsp;</td>
            <td valign="top">&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table></td>
      </tr>
    </table>
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
    	<tr>
        	<td valign="top" width="50%"><center>Requested By</center></td>
			<td valign="top" width="50%"><center>Approved By</center></td>
        </tr>
        <tr>
        	<td valign="top" width="50%">&nbsp;</td>
			<td valign="top" width="50%">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" width="50%">&nbsp;</td>
			<td valign="top" width="50%">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" width="50%">&nbsp;</td>
			<td valign="top" width="50%">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" width="50%">&nbsp;</td>
			<td valign="top" width="50%">&nbsp;</td>
        </tr>
        <tr>
        	<td valign="top" width="50%"><center><?= $tender[user_id] ?></center></td>
			<td valign="top" width="50%"><center><?= $tender[req_approval_by] ?></center></td>
        </tr>
    </table>
</body>
</html>
