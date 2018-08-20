<html>
  <head>
    <title>Envio de Arquivo</title>
     
    <audio id="anexoOK"><source src="audio/anexoOK.mp3" type="audio/mp3" /></audio>
    <audio id="anexoRM"><source src="audio/anexoRM.mp3" type="audio/mp3" /></audio>
    <audio loop id="anexoBip"><source src="audio/bip.mp3" type="audio/mp3" /></audio>
     
     
    <script type="text/javascript">
     
      function playOK() {
        var playAudio = document.getElementById("anexoOK");
         

        playAudio.play();
      }
      function playRM() {
        var playAudio = document.getElementById("anexoRM");
        playAudio.play();
      }
      function playLoading(){
        var playAudio = document.getElementById("anexoBip");
        // playAudio.volume = 0.5; 
        playAudio.play();
      }
      function stopLoading(){
        var playAudio = document.getElementById("anexoBip");
        playAudio.pause();
      }
     
      function fileRemove(){
        if(document.getElementById("fileToUpload").value != ""){
          document.getElementById("fileToUpload").value = "";
          fileSelected();
        }
      }

      function fileSelected() {

        var fup = document.getElementById('fileToUpload');
        var fileName = fup.value;
        if (fileName == ''){
            console.log("Arquivo Removido");
            playRM();
        }
        else{
            console.log(fileName);
            playOK();

        }


        var count = document.getElementById('fileToUpload').files.length;
        document.getElementById('details').innerHTML = "";
        for (var index = 0; index < count; index ++){
          var file = document.getElementById('fileToUpload').files[index];
          var fileSize = 0;
          if (file.size > 1024 * 1024)
                  fileSize = (Math.round(file.size * 100 / (1024 * 1024)) / 100).toString() + 'MB';
          else
                  fileSize = (Math.round(file.size * 100 / 1024) / 100).toString() + 'KB';
          document.getElementById('details').innerHTML += 'Name: ' + file.name + '<br>Size: ' + fileSize + '<br>Type: ' + file.type;
          document.getElementById('details').innerHTML += '<p>';
        }
      }

      function uploadFile() {  
        var fd = new FormData();
        var count = document.getElementById('fileToUpload').files.length;
        for (var index = 0; index < count; index ++){
          var file = document.getElementById('fileToUpload').files[index];
          fd.append('myFile', file); 
        }
        var xhr = new XMLHttpRequest();
        xhr.upload.addEventListener("progress", uploadProgress, false);
        xhr.addEventListener("load", uploadComplete, false);
        xhr.addEventListener("error", uploadFailed, false);
        xhr.addEventListener("abort", uploadCanceled, false);
        xhr.open("POST", "processos/moveFile.php");
        xhr.send(fd);

      }
  
      function uploadProgress(evt) {
        if (evt.lengthComputable) {
          var percentComplete = Math.round(evt.loaded * 100 / evt.total);
          document.getElementById('progress').innerHTML = percentComplete.toString() + '%';
          // document.getElementById("barra").value = percentComplete.toString();
          playLoading();
        }
  
        else {
        document.getElementById('progress').innerHTML = 'unable to compute';
  
        }
  
      }
  
      function uploadComplete(evt) {
        //  audio para fim de processo;
        stopLoading();
       
      }
  
      function uploadFailed(evt) {
        alert("There was an error attempting to upload the file.");
      }
      function uploadCanceled(evt) {
        alert("The upload has been canceled by the user or the browser dropped the connection.");
      }
     </script>
  </head>
  
  <body>
    <form id="form1" enctype="multipart/form-data" method="post" action="Upload.aspx">
      <label for="fileToUpload"></label><br />    
      <input type="file" name="fileToUpload" id="fileToUpload"  onchange="fileSelected();"/>
      <div id="details"></div>
      <br>
      <input type="button" id="remover" value="Remover" onclick="fileRemove();">
      <input type="button" onclick="uploadFile()" value="Enviar" />
      <br><br>
      <!-- <progress  id='barra' value="0" max="100" style="width:300px;"></progress> -->
      <div id="progress"></div>
      
    </form>
      
  </body>
  
</html>
