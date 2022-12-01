$(document).ready(function(){
	var url = window.location.href; 
	$("input[name = 'Rules[]']").click(function(){
		if($(this).is(":checked")){
			$(this).parent("label").find("input[name='Allow[]']").val("1");
		}else{
			$(this).parent("label").find("input[name='Allow[]']").val("0");
		}
	});
	var i_activer = 0;
	$.each($("#sidebar-menu li"),function(){
		if($(this).find("ul").length < 1){
			$(this).find("> a").find(".fa-chevron-down").remove();
		}
		var url_a = $(this).find("> a").attr("href");
		if(typeof url_a !== "undefined"){
			if(url.indexOf(url_a) != -1){
				$(this).addClass("current-page");
				$(this).parents("li").addClass("active");
				$(this).parents("li").addClass("current-page");
				$(this).parents("li").find("> ul").show();
				i_activer++;
			}
		}
	});
	if(i_activer == 0) {
		$("#sidebar-menu li.dashboard").addClass("current-page");
		$("#sidebar-menu li.dashboard").addClass("active");
	}
	$(".breadcrumb li:last-child a").click(function(){return false;})


});