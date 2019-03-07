<!-- /**
* @version $Id:21 2006-11-12 06:41:43Z $
$Date: 2010-09-20 10:40:49 -0400 (Mon, 20 Sep 2010) $
$Revision: 3986 $
$HeadURL:  $
$Id: widget_currency_calc.php 3986 2010-09-20 14:40:49Z  $  
Purpose: This widget is included into various pages that need this functionality.
Requires Assets /images/ - various currency flag icons

*/
-->
<?php require_once("exchange_rates.php");  //class holds RSS  feed details 

$rates = new exchange_rates(); //instantiate the class and fetch initial rates
?>

<form action="#" method="post" name="formx">
  <fieldset>
  <legend> <img src="images/money_dollar.png" alt="currency" width="16" height="16" />Currency and Exchange Rates </legend>
  <table border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="131"><?php 
	
	 
	$decimal="%.3f"; // format currenct into how many decimals
	
	?>
        <?php 	$from="USD"; $to="EUR"; $amt=1; 	     ?>
        $
        <input name="usd1" type="text" id="usd1" size="7" value="1" onChange="document.formx.eur.value=document.formx.usd1.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?>" />
        USD
        =</td>
      <td width="137"><input name="eur" type="text" size="11" value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"  onChange="document.formx.usd1.value=Math.round(document.formx.eur.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>));"   />
        EUR <img src="images/europeanunion.gif" alt="EUR" width="16" height="11" /> </td>
    </tr>
    <tr>
      <td><?php 	$from="USD"; $to="GBP"; $amt=1; ?>
        $
        <input name="usd2" type="text" id="usd2" size="7" value="1" onChange="document.formx.gbp.value=document.formx.usd2.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?>" />
        USD=</td>
      <td><input name="gbp" type="text"  size="11"  value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"  onChange="document.formx.usd2.value=Math.round(document.formx.gbp.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>))"  />
        GBP <img src="images/gb.gif" alt="uk" width="16" height="11" /></td>
    </tr>
    <tr>
      <td><?php 	$from="USD"; $to="CAD"; $amt=1;    ?>
        $
        <input name="usd3" type="text" id="usd3" size="7"  value="1" onChange="document.formx.cad.value=document.formx.usd3.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?>" />
        USD
        =</td>
      <td><input name="cad" type="text"  size="11"  value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"  onChange="document.formx.usd3.value=Math.round(document.formx.cad.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>))"   />
        CAD <img src="images/ca.gif" alt="uk" width="16" height="11" /></td>
    </tr>
    <tr>
      <td><?php 	$from="USD"; $to="HKD"; $amt=1;    ?>
        $
        <input name="usd4" type="text" id="usd4" size="7" value="1"  onChange="document.formx.hkd.value=document.formx.usd4.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?>" />
        USD= </td>
      <td><input name="hkd" type="text"  size="11" value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"   onChange="document.formx.usd4.value=Math.round(document.formx.hkd.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>) )"   />
        HKD <img src="images/hk.gif" alt="uk" width="16" height="11" /></td>
    </tr>
    <tr>
      <td><?php 	$from="USD"; $to="AUD"; $amt=1;    ?>
        $
        <input name="usd5" type="text" id="usd5" size="7" value="1"  onChange="document.formx.aud.value=document.formx.usd5.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?>" />
        USD=</td>
      <td><input name="aud" type="text"  size="11" value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"   onChange="document.formx.usd5.value=Math.round(document.formx.aud.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>))"   />
        AUD <img src="images/au.gif" alt="uk" width="16" height="11" /></td>
    </tr>
    <tr>
      <td><?php 	$from="USD"; $to="SGD"; $amt=1;    ?>
        $
        <input name="usd6" type="text" id="usd6" size="7" value="1"  onchange="document.formx.sgd.value=document.formx.usd6.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?>; Math.round(document.formx.usd6.value)" />
        USD=</td>
      <td><input name="sgd" type="text"  size="11" value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"   onchange="document.formx.usd6.value=Math.round(document.formx.sgd.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>))"   />
        SGD <img src="images/sg.gif" alt="uk" width="16" height="11" /></td>
    </tr>
    <tr>
      <td><?php 	$from="USD"; $to="CNY"; $amt=1;    ?>
        $
        <input name="usd7" type="text" id="usd7" size="7" value="1"  onchange="document.formx.cny.value=Math.round(document.formx.usd7.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?> )" />
        USD=</td>
      <td><input name="cny" type="text"  size="11" value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"   onchange="document.formx.usd7.value=document.formx.cny.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>)"   />
        RMB <img src="images/cn.gif" alt="uk" width="16" height="11" /></td>
    </tr>
    <tr>
      <td><?php 	$from="USD"; $to="INR"; $amt=1;    ?>
        $
        <input name="usd8" type="text" id="usd8" size="7" value="1"  onchange="document.formx.inr.value=document.formx.usd8.value*<?php printf("%.2f", $rates->exchange_rate_convert($from,$to,$amt))  ?>" />
        USD=</td>
      <td><input name="inr" type="text"  size="11" value="<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>"   onchange="document.formx.usd8.value=Math.round(document.formx.inr.value*(1/<?php printf($decimal, $rates->exchange_rate_convert($from,$to,$amt))  ?>))"   />
        INR <img src="images/in.gif" alt="uk" width="16" height="11" /></td>
    </tr>
  </table>
 
  </fieldset>
 Source: <a href="<?php echo $rates->exchange_source_url ?>"><?php echo $rates->exchange_source_url ?> </a> : Valid for <?php echo  $rates->exchange_rate_time ?> done
  <input type="button" name="Reset" id="button" value="Get Rates" onClick="location.reload();" /> <input type="reset" name="Reset" id="button" value="Reset" />  
</form>
<!-- end of Widget Form -->

  <?php 
					  
/* OPTIONAL CODE
Use the code below to save the rates to a daily exchange_rates table for future access  -optional requires database integration
$rate_usd=1;
			$rate_gbp=sprintf($decimal,  $rates->exchange_rate_convert("USD","GBP",1)  );
			$rate_eur=sprintf($decimal,  $rates->exchange_rate_convert("USD","EUR",1)  );
			$rate_hkd=sprintf($decimal,  $rates->exchange_rate_convert("USD","HKD",1)  );
			$rate_sgd=sprintf($decimal,  $rates->exchange_rate_convert("USD","SGD",1)  );
			$rate_aud=sprintf($decimal,  $rates->exchange_rate_convert("USD","AUD",1)  );
			$rate_cny=sprintf($decimal,  $rates->exchange_rate_convert("USD","CNY",1)  );
			$rate_inr=sprintf($decimal,  $rates->exchange_rate_convert("USD","INR",1)  );	 
			
				  $recs=execSqlOne("SELECT count(*)   FROM currency_exchange_rates WHERE CURRENT_DATE = updated_at ");  //is there a new date
				  if ( $recs == 0 )	//New date
				    {
				   execSQL("UPDATE currency_exchange_rates SET is_active=FALSE");	//set all old dates to false
				   execSQL("INSERT INTO currency_exchange_rates (  \"USD\", \"GBP\", \"EUR\", hkd , updated_at , is_active,\"SGD\",\"AUD\",\"CNY\",\"INR\" ) VALUES ( $rate_usd,$rate_gbp,$rate_eur,$rate_hkd, CURRENT_DATE,TRUE, $rate_sgd,$rate_aud,$rate_cny,$rate_inr)  ");
				   echo "<b> !Updated Database </b>";
			   
				   }
*/	


				  ?>

