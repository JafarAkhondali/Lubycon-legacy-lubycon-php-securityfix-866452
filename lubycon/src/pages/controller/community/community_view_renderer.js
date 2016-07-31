$(document).ready(function(){
	Request({
		url: "./pages/controller/community/viewer_controller.php",
		data: {
			cate: CATE_PARAM,
			bno: BNO_PARAM
		},
		callback: init
	});

    function init(response){
        console.log(response);
		var data = response.result;

		var title = $("#post_subject").find(".post_subject_name"),
			date = $("#post_subject").find(".written_date"),
			like = $("#post_info").find(".count_icon.like").parent(),
			view = $("#post_info").find(".count_icon.view").parent(),
			content = $("#post_contents").children("p"),
			likeButton = $(".userAction-bt[data-value='like']");

		// CONTENT DATA BINDING...
		title.text(data.contents.title);
		date.text(data.contents.date);
		like.text(data.contents.counter.like);
		view.text(data.contents.counter.view);
		content.text(data.contents.content);
		if(data.contents.like) likeButton.addClass("selected");

		// CREATOR DATA BINDING...
		creatorCardWrapper = $(".infoCard.creator"),
		creatorCard = new CreatorCard(data.creator).render();
		creatorCard.appendTo(creatorCardWrapper);

		// COMMENT DATA BINDING...
		var comment = data.comment;
		bindComment(comment);

		var commentCounter = $("#comment-counter");
		commentCounter.text(comment.length);

		var commentWriter = $(".comment-write-wrap")
		if(response.session){
			var profile = commentWriter.find(".comment-pic").children("img");
			profile.attr("src","../../../../Lubycon_contents/user/"+response.session.usercode+"/profile.jpg");
		}
		else {
			commentWriter.remove();
		}
    }

	function bindComment(data){
		for(var i = 0; i< data.length; i++){
			console.log(data[i]);
			var comment = new CommentCard(data[i]);
			console.log(comment.render());
		}
	}
});
