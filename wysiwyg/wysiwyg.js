var Form = document.getElementById("formCp");

 function enableEditMode(){
  richTextField.document.designMode = 'On';
}

function execCmd (command){
  richTextField.document.execCommand(command, false, null);
}
function execCommandwithArg(command, arg){
  richTextField.document.execCommand(command, false, arg);
}
function submit_f(){
 
  var elementExists = document.getElementById("btn_Mod_Post");
  if(!elementExists){

      btn= document.createElement("input");
      btn.setAttribute("type", "hidden");
      btn.setAttribute("name", "btn_Crea_Post");
      btn.setAttribute("value", "");
      Form.appendChild(btn);

  } else {
      var elementExists = document.getElementById("btn_Mod_Post");
      if(!elementExists){
      
          btn= document.createElement("input");
          btn.setAttribute("type", "hidden");
          btn.setAttribute("name", "btn_Mod_Post");
          btn.setAttribute("value", "");
          Form.appendChild(btn);
      }
  }

  Form.elements["myTextArea"].value = window.frames['richTextField'].document.body.innerHTML;
  Form.submit();
}
function iHead(){
  console.log();
  var x = document.getElementById("tendina").value;
  x = '<'+x+'>';
  richTextField.document.execCommand('formatBlock', false, x);
}

