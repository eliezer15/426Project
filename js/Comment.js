/* This file contains the object defintion of a Comment.
 * It also contains the client code that manages the comment pages
 */

var Comment = function(json) {
    //this.id = json.id;
    this.author = JSON.parse(json.author);
    this.content = json.content;
    this.picture = json.picture;
    this.upvotes = json.upvotes;
    this.downvotes = json.downvotes;
    this.created = new Date(json.created);
}

Comment.prototype.makeCommentDiv = function() {
    var div = $("<div></div>");
    div.addClass('comment');
    
    //div.append('<img class="user_profile_picture" src="profile.jpg" alt="profile">');
    div.append('<a href="user.php/'+ this.author.id + '" class="user_name">'+ this.author.username +'</a>');
    div.append('<p>' + this.content + '</p>');

    var li = $("<li></li>");
    li.append(div);

    return li;
}

