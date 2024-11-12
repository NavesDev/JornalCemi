import { RegTry, DataVerify, GetDate} from "./reqs.js";


var passinput=document.getElementById("uspass")
var checktext=document.getElementById("svlogt")
var emailinput=document.getElementById("usemail")
var emerror=document.getElementById("emerror")
var passbutton=document.getElementById("passhides")
var ok={
    em:false,
    pass:false,
    name:false,
    date:false
}
var hoje
async function SetDate() {
    try{
        let today=await GetDate()
        if (today && today.sucess){
            hoje=today.result
            today=today.result.substring(0,9)
            let year=Number(today.substring(0,4))
            document.getElementById("birthday").value=String(year-13)+"-01-01"
        }
    } catch (error){
        console.error(error)
    }
    
}
SetDate()
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
    if (psbox.value.length>8){
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
    evtarget.value=evtarget.value.replace(/[^a-zA-Z0-9@._%+-]/g,"")
    
    if(key.target.type=="email" && evtarget.value[0]=="-"){
        evtarget.value=evtarget.value.replace("-","")
    }
    if(key.target.id=="usname"){
        evtarget.value=evtarget.value.replace(/[^a-zA-Z0-9._-]/g,"")
        if(evtarget.value[0]=="-" || evtarget.value[0]=="_" || evtarget.value[0]=="."){
            evtarget.value=evtarget.value.replace(/[._-]/,"");
        }
    }
}

async function nameVerify(ev){
    ok["name"]=false
    try{
        let nameInput=ev.target
        let nameerror=document.getElementById("nameerror")
        if (nameInput.value.length>3){
            nameerror.innerHTML="<p class='busca'>Verificando...</p>"
            let response = await DataVerify("username",nameInput.value)
            console.log(response)
            if( response && response.sucess){
                if(response.result){
                    nameerror.innerHTML='<p class="error">* Nome de usuário já existente *</p>'
                    ok["name"]=false
                } else {
                    ok["name"]=true
                    nameerror.innerHTML=''
                }
            } else {
                ok["name"]=false
                nameerror.innerHTML='<p class="error">* Erro de conexão *</p>'
            }
        }else{
            ok["name"]=false
            if (nameInput.value.length==0){
                nameerror.innerHTML='<p class="error">* Campo obrigatório *</p>'
            } else {
                nameerror.innerHTML='<p class="error">* Seu nome deve conter mais de 3 caracteres *</p>'
            }
           
        }
    }catch(error){
        console.error(error)
    }
}

function DateVerify(ev) {
    let dti=ev.target
    if(hoje){
        if((Number(dti.value.substring(0,4))<(Number(hoje.substring(0,4)))-100) || (Number(dti.value.substring(0,4))>(Number(hoje.substring(0,4)))-13)){
            ok["date"]=false
            document.getElementById("dateerror").innerHTML='<p class="error">* Data inválida *</p>'
        } else {
            ok["date"]=true
            document.getElementById("dateerror").innerHTML=""
        }
    }    
}

async function sendData(ev){
    let sendbutton = ev.target
  
    if(ok["em"] && ok["pass"] && ok["name"] && ok["date"]){
        try{
            let response = await RegTry(emailinput.value,passinput.value,document.getElementById("usname").value,document.getElementById("birthday").value)
            
        } catch (error){
            console.warn(error)
        }
    }
}

document.getElementById("birthday").addEventListener("input",DateVerify)
document.getElementById("usname").addEventListener("input",simblelimit)
document.getElementById("usname").addEventListener("blur",nameVerify)
document.getElementById("logb").addEventListener("click",sendData)
passinput.addEventListener("blur",passverify)
passinput.addEventListener("input",simblelimit)
emailinput.addEventListener("input",simblelimit)
emailinput.addEventListener("blur",emverify)
checktext.addEventListener("click",checkmark)
passbutton.addEventListener("click",passhide)