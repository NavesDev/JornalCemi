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
    login.innerText="➤ CONTA"
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
export function newMenu(menuName, menuUrl, onlyMobile=false){
    let bmenu=window.document.getElementById("bmenu")
    let mobilemenu=window.document.getElementById("mobilemenu")
    let menuf=window.document.getElementsByClassName("menuf")
    if(!onlyMobile){
        const pcMenu=document.createElement("a")
        pcMenu.innerHTML=menuf[0].innerHTML
        pcMenu.className="menuf"
        pcMenu.innerText=menuName.toUpperCase()
        pcMenu.href=menuUrl
        document.getElementById("menu").appendChild(pcMenu)
    }

    let lbreak=document.createElement("img")
        lbreak.id="lbreakcopy"
        lbreak.src="sources/LineBreak.png"
        lbreak.className="mobilelbreak"
        mobilemenu.appendChild(lbreak)

    let nm=document.createElement("a")
    nm.innerHTML=menuf[0].innerHTML
    nm.className="mobileitem"
    nm.innerText=`➤ ${menuName.toUpperCase()}`
    nm.href=menuUrl
    mobilemenu.appendChild(nm)

}
menu();