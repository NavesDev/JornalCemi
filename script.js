import { GetBody } from "./reqs.js";
import { newMenu } from "./headerScript.js";

let body = null
export class Body{
    constructor(body,bodyname){
        Object.assign(this,body)
        this.bodyName=bodyname;
    }
    
    assignProps(prop){
        const textReqs = document.getElementsByClassName("need" + prop)
        const propValue = this[prop]
        if(textReqs.length>0 && propValue){
            for(const el of textReqs){
                if(el.tagName=="INPUT"){
                    el.value = propValue
                } else if (el.tagName=="IMG"){
                    el.src = propValue
                } else {
                    el.innerText = propValue
                }
            }
        }
    }

    assignAllProps(){
        const props = Object.keys(this)
        for(const PI in props){
           
            const prop = this[props[PI]]
            const textReqs = document.getElementsByClassName("need" + props[PI] + "f" +this.bodyName)

            if(prop && textReqs.length>0){
                for(const el of textReqs){
                    
                    if(el.tagName=="INPUT"){
                        el.value = prop
                    } else if (el.tagName=="IMG"){
                        el.src = prop
                    } else {
                        el.innerText = prop
                    }
                }
            }
        } 
    }
    }
//esse daqui abre o popupzin de sugestão
//nem sonhe em apagar algo daqui pq o site vai chora

function sugest(){
    let popup=document.getElementById("popup_sugest")
    let but1=window.document.getElementById("sugest")
    let input=window.document.getElementById("sugt")
    let pinput=window.document.getElementById('sgtexto')
    let exitbut=window.document.getElementById("x-vetor")
    function clicked(){
            popup.style.display="flex"
            pinput.innerText="Seu texto vai aparecer aqui."
            input.value=""
    }

    function quit(){
        popup.style.display="none "
    }
    
    function changed(){
        if (input.value==""){
            pinput.innerText="Seu texto vai aparecer aqui."
        }else{
            pinput.innerText=input.value
        }    
    }
    exitbut.addEventListener("click",quit)
    but1.addEventListener("click",clicked)
    input.addEventListener("input",changed)
}

async function bodyFuncs() {
    try{
        const req = await GetBody()
    if(req.sucess){
        const body = new Body(req.body,"user")
    }
    } catch(error){
        console.error(error)
    }
    
    
}

//esse aqui vai roda os bagui básico do site
Main()
function Main(){
    sugest()
    bodyFuncs()
    
}


// Desenvolvido por Miiler Dev :D