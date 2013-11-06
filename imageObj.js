var ImageObj = function(url) {
    this.url = url;

    ImageObj.all.push(this);
}

ImageObj.all = new Array();

ImageObj.last_id = 0;

ImageObj.generateId = function () {
    ImageObj.last_id += 1;
    return ImageObj.last_id;
}

ImageObj.generate = function() {
var urls = ["images/photo1.jpg","images/photo2.jpg","images/photo3.jpg"];

for(var i=0; i<100; i++) {

var url = urls[Math.ceil(3*Math.random())];

new ImageObj(url);
}


}

ImageObj.generate();

