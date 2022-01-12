<!DOCTYPE html>
<html>
    <head>
        <title>Rich text editor in JS</title>
        <link rel="stylesheet" href="wysiwyg.css">
        <script src="https://kit.fontawesome.com/6e8cae6392.js" crossorigin="anonymous"></script>
    </head>
    <body onload="enableEditMode();">
        <form action="submit.php" name="myform" id="myform" method="post">
            <label class="LICP">Inserisci il Titolo del tuo post</label>
            
            <input type="text" name="titolo" value ="<?php //echo $titolo ?>" maxlength="40" />
            <br> <br>
            <label class="LICP">Corpo testuale</label>
            <div class="input-icons"style="border:#000000 1px solid; width:454px;">
                <div class="line">
                    <i class="fa fa-bold icon"></i>
                    <input type="button" class="input-field" title="bold"onclick="execCmd('bold');"/>
                
                    
                    <i class="fa fa-italic icon"></i> 
                    <input type="button" class="input-field" title="italic"onclick="execCmd('italic');"/>
                
                 
                    <i class="fa fa-underline icon"></i>
                    <input type="button" class="input-field" title="underline"onclick="execCmd('underline');"/>
                
                 
                    <i class="fa fa-strikethrough icon"></i>
                    <input type="button" class="input-field" title="strikethrough"onclick="execCmd('strikeThrough');"/>
                
                 
                    <i class="fa fa-align-left icon"></i>
                    <input type="button" class="input-field" title="align-left"onclick="execCmd('justifyLeft');"/>
                
                
                    <i class="fa fa-align-center icon"></i>  
                    <input type="button" class="input-field" title="align-center"onclick="execCmd('justifyCenter');"/>
                
                 
                    <i class="fa fa-align-right icon"></i>  
                    <input type="button" class="input-field" title="align-right"onclick="execCmd('justifyRight');"/>
                
                
                    <i class="fa fa-align-justify icon"></i> 
                    <input type="button" class="input-field" title="justify"onclick="execCmd('justifyFull');"/>
                
                
                    <i class="fa fa-cut icon"></i>   
                    <input type="button" class="input-field" title="cut"onclick="execCmd('cut');"/>
                
                
                    <i class="fa fa-copy icon"></i>
                    <input type="button" class="input-field" title="copy"onclick="execCmd('copy');"/>
                
                    
                    <i class="fa fa-indent icon"></i>
                    <input type="button" class="input-field" title="indent"onclick="execCmd('indent');"/>
                
                 
                    <i class="fa fa-dedent icon"></i>
                    <input type="button" class="input-field" title="outdent"onclick="execCmd('outdent');"/>
                
                    
                    <i class="fa fa-subscript icon"></i> 
                    <input type="button" class="input-field" title="subscript"onclick="execCmd('subscript');"/>
                
                
                    <i class="fa fa-superscript icon"></i>
                    <input type="button" class="input-field" title="superscript"onclick="execCmd('superscript');"/>
                
                   
                    <i class="fa fa-undo icon"></i> 
                    <input type="button" class="input-field" title="undo"onclick="execCmd('undo');"/>
                
                   
                    <i class="fa fa-redo icon"></i>
                    <input type="button" class="input-field" title="redo"onclick="execCmd('redo');"/>
                
                   
                    <i class="fa fa-list-ul icon"></i>
                    <input type="button" class="input-field" title="unordered-list"onclick="execCmd('insertUnorderedList');"/>
                
                    
                    <i class="fa fa-list-ol icon"></i>
                    <input type="button" class="input-field" title="ordered-list"onclick="execCmd('insertOrderedList');"/>
                
                    
                    <i class="fa fa-paragraph icon"></i>
                    <input type="button" class="input-field" title="paragraph"onclick="execCmd('insertParagraph');"/>
                
                
                
                    <i class="icon">H </i>  
                    <input type="button" class="input-field" title="horizontal-rule"onclick="execCmd('insertHorizontalRule');"/>
                
                    <i class="fa fa-link icon"></i> 
                    <input type="button" class="input-field" title="link"onclick="execCommandwithArg('createLink', prompt('Inserisci un URL', 'http:' ));"/>
                
                
                    <i class="fa fa-unlink icon"></i>
                    <input type ="button" class="input-field" title="unlink"onclick="execCmd('unlink');"/>
                   
                    
                </div>
                <select title="title"onclick="execCommandwithArg('format', this.value);">
                        <option value="H1">H1</option>
                        <option value="H2">H2</option>
                        <option value="H3">H3</option>
                        <option value="H4">H4</option>
                        <option value="H5">H5</option>
                        <option value="H6">H6</option>
                    </select>
    
                    <select title="Font"onclick="execCommandwithArg('fontName', this.value);">
                        <option value='Arial'>Arial</option>
                        <option value='ComicSansMS'>Comic Sans MS</option>
                        <option value='Courier'>Courier</option>
                        <option value='Georgia'>Georgia</option>
                        <option value='Tahoma'>Tahoma</option>
                        <option value='TimesNewRoman'>Times New Roman</option>
                        <option value='Verdana'>Verdana</option>
                    </select>
                    <select title="font-size" onclick="execCommandwithArg('fontSize', this.value);">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5">5</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                    </select>
                
                <!--Migliorare scelta colori -->
                Fore Color  <input type="color" onclick="execCommandwithArg('foreColor', this.value);"/> 
                Background  <input type="color" onclick="execCommandwithArg('hiliteColor', this.value);"/>
            </div>
                    <textarea style="display:none;" name="myTextArea" id="myTextArea" cols="100" rows="14"></textarea>
                
                    <iframe name="richTextField" style="border:#000000 1px solid; width:700px; height:300px;"></iframe>
            
                    
                    <label class="LICP">Seleziona un'immagine per il tuo Post:</label>
					<input type="file" name="fileToUpload" id="fileToUpload">
                    <input name="myBtn" id="btn_Mod_Post" type="button" value="Submit Data" onclick="javascript:submit_f();" />
        </form>
        <script type="text/javascript">
            var showSource = false;
            var edMode = true;
            
            function enableEditMode (){
                richTextField.document.designMode = 'On';
            }
            
            function execCmd (command){
                richTextField.document.execCommand(command, false, null);
            }
            function execCommandwithArg(command, arg){
                richTextField.document.execCommand(command, false, arg);
            }
            function submit_f(){
                var Form = document.getElementById("myform");
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
        </script>
    </body>
</html>