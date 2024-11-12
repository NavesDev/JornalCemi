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

function menu(){
    //mano menuzin bonitin
    let bmenu=window.document.getElementById("bmenu")
    let mobilemenu=window.document.getElementById("mobilemenu")
    let menuf=window.document.getElementsByClassName("menuf")
    for (let i=0;i<menuf.length;i++){
        let child=document.createElement("a")
        child.innerHTML=menuf[i].innerHTML
        child.className="mobileitem"
        child.innerText="➤ "+child.innerText
        mobilemenu.appendChild(child)
        let lbreak=document.createElement("img")
        lbreak.id="lbreakcopy"
        lbreak.src="sources/LineBreak.png"
        lbreak.className="mobilelbreak"
        mobilemenu.appendChild(lbreak)
    }
    let login=document.createElement("a")
    login.innerHTML=menuf[0].innerHTML
    login.className="mobileitem"
    login.innerText="➤ LOGIN"
    mobilemenu.appendChild(login)

    function openclose(){
        console.warn()
        if(window.innerWidth<=1062)
        if (mobilemenu.style.display=="flex"){
            mobilemenu.style.display="none"
        }else{
            mobilemenu.style.display="flex"
        }
    }
    function verify(){
        if(window.innerWidth>1062){
            mobilemenu.style.display="none"
        }
    }
    function clickout(evento){
        if (!mobilemenu.contains(evento.target) && !bmenu.contains(evento.target)){
            
            mobilemenu.style.display="none"
        }
    }
    bmenu.addEventListener("click",openclose)
    window.addEventListener("resize",verify)
    document.addEventListener("touchstart",clickout)
}

//esse aqui vai roda os bagui básico do site
Main()
function Main(){
    sugest()
    menu()
}

// Desenvolvido por Miiler Dev :D