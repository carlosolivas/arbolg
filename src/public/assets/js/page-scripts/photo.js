$(function(){ // on dom ready

 // By default, the entity is returning the url file with an additional "/"
  var src = $("#photoPreview").attr("src");
  src = src.substring(0, src.length - 1);
  $("#photoPreview").attr("src",src);
});

function PreviewPhoto() {
    var fr = new FileReader();
    fr.readAsDataURL(document.getElementById("photo").files[0]);

    fr.onload = function (oFREvent) {
        document.getElementById("photoPreview").src = oFREvent.target.result;
    };
};