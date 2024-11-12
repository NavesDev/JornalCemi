import { LogTry } from "./reqs.js";

var passinput=document.getElementById("uspass")
var checktext=document.getElementById("svlogt")
var emailinput=document.getElementById("usemail")
var emerror=document.getElementById("emerror")
var passbutton=document.getElementById("passhides")
var ok={
    em:false,
    pass:false
}

function passhide(){
    
    if (passinput.type=="text"){
        passinput.type="password"
       passbutton.src="sources/pass.svg"
       
    }else{
        passinput.type="text"
        passbutton.src="sources/passhide.svg"
        
    }
}

function checkmark(){
    if (document.getElementById("svlog").checked){
        document.getElementById("svlog").checked=false
    }else{
        document.getElementById("svlog").checked=true
    }
}

function emverify(){
    let emlis=emailinput.value.split("@")
    let eme=document.getElementById("emerror")
    if (emailinput.value.length>0 && emailinput.value.includes("@") && emlis[1].includes(".") && emlis[1].split(".")[1].length>=2 && emlis[0].length>3 && emlis[1].split(".").length==2 && emailinput.value[emailinput.value.length-1]!="-"){
        ok["em"]=true
        eme.innerHTML=''  
    }else{
        ok["em"]=false
        if(emailinput.value.length<=0){ 
            eme.innerHTML='<p class="error">* Campo obrigatório *</p>'
        }else if(emailinput.value.includes("@")==false){
            eme.innerHTML='<p class="error">* Seu email deve conter "@" *</p>'    
        }else if(emailinput.value[emailinput.value.length-1]=="-"){
            eme.innerHTML='<p class="error">* Seu email não pode terminar em "-" *</p>'
        }
        else{
            eme.innerHTML='<p class="error">* Email inválido *</p>'
        }
    }
}

function passverify(event){
    let psbox=event.target
    let paserro=document.getElementById("passerror")
    if (psbox.value.length>=8){
        ok["pass"]=true
        paserro.innerHTML=""
    }else{
        ok["pass"]=false
        if (psbox.value.length==0){
            paserro.innerHTML='<p class="error">* Campo obrigatório *</p>'
        } else {
            paserro.innerHTML='<p class="error">* Sua senha deve conter pelo menos 8 caracteres *</p>'
        }
       
    }
}

function simblelimit(key){
    let evtarget=key.target
    
    
    
    if(key.target.type=="email" && evtarget.value[0]=="-"){
        evtarget.value=evtarget.value.replace("-","")
    } else if(evtarget.id=="usemail"){
        evtarget.value = evtarget.value.replace(/[^a-zA-Z0-9@.!#$%&'*/=?^_+-`{|}~]/g, "");
    } else if(evtarget.id=="uspass"){
        evtarget.value = evtarget.value.replace(/[^a-zA-Z0-9@._%+\-!#$^&*()=+[\]{};:'",<>\./?\\|~`-]/g, "");
    }
}

async function sendData(ev){
    let sendbutton = ev.target
    console.log("Fui clicado")
    if(ok["em"] && ok["pass"]){
        try{
            let response = await LogTry(emailinput.value,passinput.value)
            if(response.logged && response.sucess){
                console.log("Deu ruim")
            } else {
                document.getElementById("logerror").innerHTML = `<p class="error">* ${response["msg"]} *</p>`
            }
        } catch (error){
            console.warn(error)
        }
    }
}

document.getElementById("logb").addEventListener("click",sendData)
passinput.addEventListener("blur",passverify)
passinput.addEventListener("input",simblelimit)
emailinput.addEventListener("input",simblelimit)
emailinput.addEventListener("blur",emverify)
checktext.addEventListener("click",checkmark)
passbutton.addEventListener("click",passhide)