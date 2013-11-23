var imageObj = function(url, id) {
	this.id = imageObj.generateId();
    this.url = url;
    imageObj.all.push(this);
}

imageObj.all = new Array();

imageObj.last_id = 0;

imageObj.generateId = function () {
    imageObj.last_id += 1;
    return imageObj.last_id;
}

imageObj.generate = function() {
var urls = ["images/photo1.jpg","images/photo2.jpg","images/photo3.jpg"];

for(var i=0; i<100; i++) {

var url = urls[Math.floor(3*Math.random())];

new imageObj(url);
}


}

imageObj.generate();

