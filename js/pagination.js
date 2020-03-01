//Pagination
		pageSize = 5;

		var pageCount =  $(".line-content").length / pageSize;

		for(var i = 0 ; i<pageCount;i++){
       $("#pagin").append('<li class="page-item"><a class="page-link" name="'+(i+1)+'">'+(i+1)+'</a></li> ');
   }
   $("#pagin li").first().find("a").addClass("current")
   showPage = function(page) {
   	$(".line-content").hide();
   	$(".line-content").each(function(n) {
   		if (n >= pageSize * (page - 1) && n < pageSize * page)
   			$(this).show();
   	});        
   }

   showPage(1);

   $("#pagin li a").click(function() {
   	$("#pagin li a").removeClass("current");
   	$(this).addClass("current");
   	showPage(parseInt($(this).text())) 
   });

   $("#next a").click(function(){
   	let cp = document.querySelector('.current');
   	let np = parseInt(cp.text)+1;
   	let nn = document.querySelector('a[name="'+np+'"]');
   	if(nn){
   		cp.classList.remove("current");
   		nn.classList.add("current");
   		showPage(np);
   	}
   });


   $("#previous a").click(function(){
   	let cp = document.querySelector('.current');
   	let np = parseInt(cp.text)-1;
   	let nn = document.querySelector('a[name="'+np+'"]');
   	if(nn){
   		cp.classList.remove("current");
   		nn.classList.add("current");
   		showPage(np);
   	}
   });