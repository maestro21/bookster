var j = jQuery.noConflict();

/** common **/

function doSearch(pre){
	location.href=pre+'/items/1/'+$('search').value;
}

function conf(url){
	if(confirm("Are you sure you want it ?")){
		location.href=url;
	}
}


/** jquery **/


j( document ).ready(function() {
    j('.click').click(function() {
	  j( ".errors p" ).hide();
	});
});

/*
function ajax_request(url, data, callback ){
	$.ajax({
		type: 		'post',
		url: 		url,
		data: 		data,
		dataType: 	"json",
		success: 	callback
	});
}*/

function checkLoginForm(){
	form = j('#loginForm');
	j.ajax({
		type: 	form.attr('method'),
		url: 	form.attr('action'),
		data: 	form.serialize(),
		success: function(res, status) {
		   if (res == 'ok') {
				location.href='<?=BASE_PATH;?>';
			} else {
				j('#loginForm .errors p').show();
			}
		}
	});
}

function checkMailForm(){
	form = j('#recoverForm');
	j.ajax({
		type: 	form.attr('method'),
		url: 	form.attr('action'),
		data: 	form.serialize(),
		success: function(res, status) {
		   if (res == 'ok') {
				j("#modal-recover .modalwindow").html(j("#sentmail").html());
				setTimeout(function(){location.href='<?=BASE_PATH;?>';},3000);				
			} else {
				j('#recoverForm .success p').hide();
				j('#recoverForm .errors p').show();
			}
		}
	});
}

function checkRegForm() { //alert('111');
	var form 	= j('#regiForm');
	var name 	= j('#regName').val();
	var surname = j('#regSurName').val();
	var mail	= j('#regMail').val();
	var pass 	= j('#regPass').val();
	var no_errors 	= true;
	
	j('.errors p').hide();

	if (!( (name.length > 2 && name != '<?=T("first name");?>' ) && (surname.length > 2 && surname != '<?=T("last name");?>') )) {
		j('.errors .fieldserror').fadeIn(); 
		no_errors = false;
	}
	
	if (! ( checkChars(name,true) && checkChars(surname,true) ) ) {
		j('.errors .formaterror').fadeIn();
		no_errors = false;
	}				
	
	if (!isValidEmail(mail)) {
		j('.errors .mailerror').fadeIn();
		no_errors = false;
	}			
	
	if(no_errors) {			
		j.ajax({
			type: 	form.attr('method'),
			url: 	form.attr('action'),
			data: 	form.serialize(),
			success: function(res, status) {
			   if (res == 'ok') {
				location.href='<?=BASE_PATH;?>';
				} else {
					j('.errors .alreadyRegistered').fadeIn();
				}
			}
		});
	}
}



/** ajax **/

function showHide(id){
	if($(id).style.display=='block')
		$(id).style.display='none';
	else
		$(id).style.display='block';
}

function showHideH(id){
	if(document.getElementById(id).style.display=='block'){ // show => hide (hiding)
		$(id).style.display='none';
		$('i_'+id).src = '<?=PUB;?>'+'img/'+	id + '.png';
	}else{ //hide => show (showing)
		$(id).style.display='block';			
		$('i_'+id).src = '<?=PUB;?>'+'img/'+	id + '_h.png';
	}
}


var dest = ''; var draw = '';
//ladder functions
function drawSelect(table,id,idfield,dst,drawNext,defValue){
	dest = dst; draw = drawNext; 
	ajax_request('<?=BASE_PATH;?>ajax.php','do=drawSelectById&table='+table+'&id='+id+'&idfield='+idfield+'&value='+defValue,postLadder);
}
function postLadder(resp){
	var res = resp.responseText;
	if(draw !=''){
		$(dest+'div').innerHTML = "<select name='form["+dest+"_id]' id='"+dest+"sel' onchange='"+draw+"()'>"+res + "</select>";
	}else{
		$(dest+'div').innerHTML = "<select name='form["+dest+"_id]' id='"+dest+"sel'>"+res + "</select>";
	}
}

function setSelVal(val,list){
	for (var i = 0; i < $(list).length; i++) {
		if($(list).options[i].value == val)	
			$(list).options[i].selected=true;
		else
			$(list).options[i].selected=false;
	}
}

function clearSels(lvl){
	var divs=new Array("city","uni","faculty", "specialization");
	for (var i = lvl; i<4; i++){
		$(divs[i]+"div").innerHTML="<select name='form["+divs[i]+"_id]'><option value='0'>- <?=T('Not selected');?> -</option></select>";
	}
}

function drawCities(){
	var countryid = $('countrysel').value;
	drawSelect('cities',countryid,'country_id','city','drawUnies','');
	if(countryid>0) clearSels(1); else clearSels(0);
}

function drawUnies(){
	var uniid = $('citysel').value;
	drawSelect('universities',uniid,'city_id','uni','drawFacs','');
	if(uniid>0) clearSels(2); else clearSels(1);
}

function drawFacs(){
	var facid = $('unisel').value;
	drawSelect('faculties',facid,'uni_id','faculty','drawSpec','');
	if(facid>0) clearSels(3); else clearSels(2);
}

function drawSpec(){
	var facid = $('facultysel').value;
	drawSelect('specialization',facid,'faculty_id','specialization','','');
	if(facid==0) clearSels(3);
}

function drawSeminars(){ ajax_request('<?=BASE_PATH;?>ajax.php','do=drawSeminarSelect&fac='+$('facultysel').value+'&spec='+$('specializationsel').value+'&term='+$('termsel').value,_drawSeminars); }
function _drawSeminars(resp){
	var res = resp.responseText;
	$('seminardiv').innerHTML = "<select name='form[seminar]'>" + res + "</select>";
}

function empt(item,val,id, k){
	item.className = k + ' active';
	if(null !=id){
		item = document.getElementById(id);
		if(item.innerHTML==val) item.innerHTML='';
	}else
		if(item.value==val) item.value='';
}	

function chk(item,val,id, k){
	item.className = k + ' inactive';
	if(item.value=='') {
		if(null !=id){
			prev = document.getElementById(id);
			prev.innerHTML = val;
		} else {
			item.value=val;
		}	
	}
}

function sndSearch(id,pre,module){
	if($(id).value.trim() =='') return false;
	 location.href=pre + 'search/'+$(id).value+'/'+module;
}

function pubSearch(pre,id,module){
	location.href = pre + 'search/'+$(id).value+'/'+module;
}

function clickSearch(e,pre,id,module) {
if($(id).value.trim() =='') return false;
 var keynum
 var keychar
 var numcheck
 if(window.event) // IE
 {
  keynum = e.keyCode
 }
 else if(e.which) // Netscape/Firefox/Opera
 {
  keynum = e.which
 }

 if(keynum == 13)  location.href=pre + 'search/'+$(id).value+'/'+module;
}

function checkEduForm(){ $('eduform').submit();
/*	if($('specializationsel') != null){
		if($('specializationsel').value !='---'){
			$('eduform').submit();
		}
	}else{
		$('errors').innerHTML = "<div><?=T('fieldserror');?></div>";
	}*/
}

function checkChars(field,digits){
	var iChars = "!@#$%^&*()+=-[]\\\';,./{}|\":<>?";
	if(digits) iChars +='0123456789'; 
	  for (var i = 0; i < field.length; i++) {
		if (iChars.indexOf(field.charAt(i)) != -1) {
			//alert(field.charAt(i));
		return false;
		}
	  }
	 return true; 
}

function isValidEmail (mail)
{
//alert(mail);
 //email = email.replace(/^\s+|\s+$/g, '');
 var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/
 return (filter).test(mail);
}

function helpSearch(pre){
	location.href=pre + $('hSearch').value;
}


function setSelectionRange(input, selectionStart, selectionEnd) {
  if (input.setSelectionRange) {
    input.focus();
    input.setSelectionRange(selectionStart, selectionEnd);
  }
  else if (input.createTextRange) {
    var range = input.createTextRange();
    range.collapse(true);
    range.moveEnd('character', selectionEnd);
    range.moveStart('character', selectionStart);
    range.select();
  }
}

function setCaretToPos (input, pos) {
  setSelectionRange(input, pos, pos);
}

function getNic(name){
	var nicE = new nicEditors.findEditor(name);
	$(name).value=nicE.getContent();
}


function refreshSummaries(page){  ajax_request('<?=BASE_PATH;?>summaries/_list/'+page,$('refOptionForm').serialize(), _refreshSummaries); }
function _refreshSummaries(resp){
	var res = resp.responseText;
	$('summary_content').innerHTML =  res;
	//alert(res);
}

function checkAll(wat,on){	
	if(wat == 'item') 
		j('#'+on).removeAttr('checked');
	else
		j('.'+on).removeAttr('checked');		
		
	refreshSummaries(0);	
}


// Social login
function authInfo(response) {
  if (response.session) {
	id = response.session.mid;
	VK.Api.call('users.get', {uids: id, fields: 'sex,photo_big'}, function(r) {
        if(r.response) {
		    console.log(r.response[0]);
		    response = r.response[0];
		    j.post( '<?=BASE_PATH;?>users/soclog1n',
				  {
					name: 	 response.first_name,
					surname: response.last_name,
					email:	 "",
					img:	 response.photo_big,
					social_id: response.uid,	
					social_type: "vk",
					
				  }
			).done(function(response) {
				console.log(response);
				location.href='<?=BASE_PATH;?>';
			});
		}
	    });
		//alert(response.session);
    //alert('user: '+response.session.mid);
  } else {
    alert('not auth');
  }
}

function doFBLogin() {  
    FB.login(function(response) {  
        if (response.authResponse) {  
            var token = response.authResponse.accessToken;  
            //define the login function on your client through FB  
	    //alert(token);
	    FB.api('/me', function(response) {
		  console.log(response);
		  j.post(  '<?=BASE_PATH;?>users/soclog1n',
				  {
					name: 	 response.first_name,
					surname: response.last_name,
					email:	 response.email,
					img:	 "http://graph.facebook.com/" + response.id + "/picture?type=large",
					social_id: response.id,	
					social_type: "fb",
					
				  }
			).done(function(response) {
				console.log(response);
				location.href='<?=BASE_PATH;?>';
			  //alert('ok');
			});
		});
        } else {  
            //processing an error  
        }  
    }, {scope:'email'});  
}    


function changeLang(lang){
	window.location='<?=BASE_PATH;?>filter/lang/' + lang;
}


function checkSummaryForm() { 
	ajax_request('<?=BASE_PATH;?>summaries/checkname', 	
		{name:$('name').value},
		postCheckSummaryForm); }
function postCheckSummaryForm(resp) {
	response = resp.responseText;
	if(response == 'ok') 
		$('sumform').submit();
	else {
		$('sum_exists_error_div').style.display='block';
	}
}

