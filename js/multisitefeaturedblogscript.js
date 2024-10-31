function getblogdetailsbuttonClicked()
{
  	 var blogid = jQuery("#blogid").val(); 

  	jQuery.ajax({
	  type: 'POST',
	  url: ajaxurl,
	  data: {
		action: 'mfb_ajax_get_blog_details',
		blogid: blogid
	  },

	 success:function(data, textStatus, XMLHttpRequest){
  		
		  jQuery("#blogdetails").html('');
		  jQuery("#blogdetails").append(data);
	  },
	 error: function(MLHttpRequest, textStatus, errorThrown){
	  alert(errorThrown);
	  }
	 });
 }

 function addblogbuttonClicked(blogid,blogname)
 {
	jQuery('#blogidlistbox').append('<option value="' + blogid + '">' + blogname + '</option>');
	cleanblogDetails();
 }

 function cancelblogbuttonClicked(blogid)
 {
		cleanblogDetails();
 }

 function cleanblogDetails(blogid)
 {
	jQuery("#blogdetails").html('');
	jQuery("#blogid").val('');
 }

 function removeSelectedBlog()
 {
	
	var selectedItems = jQuery('#blogidlistbox ' + "option:selected");
	selectedItems.remove();
 }

 function mfbsettingformsubmit()
 {
	 var blogidlist = '';
	jQuery("#blogidlistbox option").each(function()
	{
		if(blogidlist.length == 0)
			blogidlist = jQuery(this).val();
		else
			blogidlist = blogidlist + "," + jQuery(this).val();
		
	});

	jQuery("#blogidlist").val(blogidlist);
	document.mfbsettingform.submit();
 }