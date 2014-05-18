<? if($_filter){ 
	$data = array(
		'confirmed' => 2,
		'country' 	=> (int)getVar('edu_country'),
		'city_id' 	=> (int)getVar('edu_city'),
		'uni_id' 	=> (int)getVar('edu_uni'),
		'specialization_id' => (int)getVar('edu_spec'),
		'faculty_id'=> (int)getVar('edu_fac'),
		'term' 		=> (int)getVar('edu_term'),
		'seminar' 	=> (int)getVar('edu_sem'),
	);
?> 
<h1 style="padding-left:12px;"><a href="javascript:void(0);" onclick="showHide('edufilterdiv')"><b><?=T('adm_filter');?></b></a></h1>
<div id="edufilterdiv" class="dropdownmenu">
<form  method="POST" action="<?=BASE_PATH;?>users/savefilters" id="eduform">
<? } ?>
	<table class="wrp" cellspacing="0">
		 <tr>
			 <td colspan=3>
				<h4><b>
				<? if($_filter){ echo T('Change filter'); } else {?>	
				<?  if($data['confirmed'] < 2 ) { echo $data['name'].", ".T('let`s get your profile started');
				 } else { ?> <a href="javascript:void(0)"><?=T('Change education data');?></a> <? } ?>
				<? } ?>
				</b></h4>
			 </td>

		 </tr>

		 

		 <tr>
			<td class="tbleft">
			<?=T('Country');?>:
			</td>
			<td class="sel">
				<? $countries = DBall("SELECT * FROM countries"); ?>
				<select name="form[country]" id="countrysel" onchange="drawCities()">
					<option value='0'>- <?=T('Not selected');?> -</option>
					<? foreach($countries as $country){ ?>
						<option value="<?=$country['id'];?>"<? if($data['country']==$country['id']) echo "SELECTED"; ?>><?=T($country['name']);?></option>
					<?} ?>
				</select>
			</td>			
		 </tr>
		  <tr>
			<td class="tbleft">
				<?=T('City');?>:
			</td>
			<td id="citydiv" class="sel">
				<?  if($data['country'] > 0 ){ ?>
					<select onchange="drawUnies()" id="citysel" name="form[city_id]"><?
						drawSelById('cities','country_id',$data['city_id'],$data['country']);
					}else{ ;?>
						<select><option value='0'>- <?=T('Not selected');?> -</option>
				<? } ?>
				</select>
			</td>		 
		 </tr>
		  <tr>
			<td class="tbleft">
				<?=T('University');?>:
			</td>
			<td id="unidiv" class="sel">
				<?  if($data['city_id'] > 0 ){ ?>
					<select onchange="drawFacs()" id="unisel" name="form[uni_id]"><?
						drawSelById('universities','city_id',$data['uni_id'],$data['city_id']);
					}else{ ;?>
						<select><option value='0'>- <?=T('Not selected');?> -</option>
				<? } ?>
				</select>
			</td>	 
		 </tr>
		  <tr>
			<td class="tbleft">
				<?=T('Faculty');?>:
			</td>
			<td id="facultydiv" class="sel">
			<?  if($data['faculty_id'] > 0 ){ ?>
					<select onchange="drawSpec();drawSeminars()" id="facultysel" name="form[faculty_id]"><?
						drawSelById('faculties','uni_id',$data['faculty_id'],$data['uni_id']);
					}else{ ;?>
						<select><option value='0'>- <?=T('Not selected');?> -</option>
				<? } ?>
				</select>
			</td>		 
		</tr>
		<tr>
			<td class="tbleft">
				<?=T('Specialization');?>:
			</td>
			<td id="specializationdiv" class="sel">
				<?  if($data['specialization_id'] > 0 ){ ?>
					<select id="specializationsel" onchange="drawSeminars()" name="form[specialization_id]"><?
						drawSelById('specialization','faculty_id',$data['specialization_id'],$data['faculty_id']);
					}else{ ;?>
						<select><option value='0'>- <?=T('Not selected');?> -</option>
				<? } ?>
				</select>
			</td>		 
		 </tr>
		 <tr>
			<td class="tbleft">
				<?=T('Term');?>:				
			</td>
			<td class="sel">
				<select name="form[term]" onchange="drawSeminars()" id="termsel">
					<option value='0'>- <?=T('Not selected');?> -</option>
					<? for ($i = 1 ; $i<11 ; $i++){  ?>
						<option value="<?=$i;?>"<? if($data['term']==$i) echo "SELECTED"; ?>><?=$i.' '.T('term');;?></option>						
					<? } ?>
					<option value="11"><?=T('graduated');?></option>
				</select> 
			</td>
		 </tr>
		 
		 <? if($_filter){ ?>
		 <tr>
			<td class="tbleft">
				<?=T('Seminar');?>:
			</td>
			<td id="seminardiv" class="sel">
					<select name="form[seminar]">
						<option value='0'>- <?=T('Not selected');?> -</option>
					<?	$fac  = (int) $data['faculty_id'];
						$spec = (int) $data['specialization_id'];
						$term = (int) $data['term'];
						$sem  = (int) $data['seminar'];						
						if($fac > 0){
							$sql = "SELECT * FROM seminars WHERE faculty_id = $fac";
							if($spec > 0) $sql .= " AND specialization_id = $spec";
							if($term > 0) $sql .= " AND term_id = $term";
							$res = dbAll($sql);// echo $sql; print_r($res);
							foreach ($res as $seminar){
								echo "<option value='".$seminar['id']."'".($sem==$seminar['id']?' selected=SELECTED':'').">".$seminar['name']."</option>";
							}
						} ?>
				</select>
			</td>		 
		 </tr>
		 <? } ?>
		 
		 <!--  <tr>
			<td class="tbleft">
				<?/*=T('Years attended');?>
			</td>
			<td>
				<?=T('from');?>
				<select name="form[yfrom]">
					<? for ($i=1990; $i<2020; $i++){ ?>
					<option value="<?=$i;?>"><?=$i;?></option>
					<? } ?>
				</select> 
				<?=T('to');?>
				<select name="form[yto]">
					<? for ($i=1990; $i<2020; $i++){ ?>
					<option value="<?=$i;?>"><?=$i;?></option>
					<? } */?>
				</select> 
			</td>		 
		 </tr>	-->
		 <tr>
			<td>
				
			</td>
			<td>
				<a href="javascript:void(0)" onclick="checkEduForm()" <? if($_filter){ ?> style="display:inline !important"<?}?>>
					<div class="button insBtn"><?=T(($data['confirmed'] < 2 ?'create profile':'save'));?></div>
				</a>
			</td>
		 </tr>
		  <tr>
		 	<td></td>
		 	<td id="errors">
		 	
		 	</td>
		 </tr>
	</table>

<? if($_filter){ ?>
</form>
</div>
<? } ?>	