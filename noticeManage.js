import { NewPub } from "./reqs.js"

function baseFuncs() {
    let ok = {
        "title": false,
        "desc": false,
        "thumb" : false
    }

    const titleValue = document.getElementById("news_title")
    const desc = document.getElementById("news_content")
    const sendB = document.getElementById("sendB")
    const thumb = document.getElementById("news_image")
    const myDropZone = document.getElementById("news_dropzone")

    function geralView(){
        let geralOk = true
        for(const i in ok){
            if(!ok[i]){
                geralOk=false
            }            
        }
        if(geralOk){
            sendB.disabled=false    
        } else {
            sendB.disabled=true
        }
        return geralOk
    }
    geralView()

    sendB.addEventListener("click",()=>{
        if(geralView()){
            let rep = NewPub(titleValue.value,desc.value)
        }
    })
    myDropZone.addEventListener("dragover",(ev)=>{
        ev.preventDefault();
        myDropZone.classList.add("dragover")
    })
    myDropZone.addEventListener("dragleave",()=>{
        myDropZone.classList.remove("dragover")
    })

    myDropZone.addEventListener("drop",(ev)=>{
        ev.preventDefault();
        myDropZone.classList.remove("dragover");
        const DT = new DataTransfer()
        const img = ev.dataTransfer.files[0]
        DT.items.add(img)
        const maxSize= 1024*1024
        if(DT.files.length>0){
            if(img && img.type.startsWith("image/") && img.size<maxSize){
                thumb.files = DT.files
                ok.thumb=true
            } else {
                ok.thumb=false
            }
        } else {
            ok.thumb=false
        }
        geralView()
        
    })
    myDropZone.addEventListener("click",()=> {
        thumb.click();
    })
    titleValue.addEventListener("input", () => {
        if (titleValue.value.length >=20 && titleValue.value.length <= 100) {
            ok.title = true
        } else {
            ok.title = false
        }
        console.log(ok)
        geralView()
    })
    desc.addEventListener("input",()=>{
        if(desc.value.length>=30 && desc.value.length<=300){
            ok.desc = true
        } else {
            ok.desc = false
        }
        geralView()
    })
    thumb.addEventListener("change",()=>{
        const maxSize= 1024*1024
        if(thumb.files.length>0){
            const img = thumb.files[0]
            if(img && img.type.startsWith("image/") && img.size<maxSize){
                ok.thumb=true
            } else {
                thumb.files = new DataTransfer().files
                ok.thumb=false
            }
        } else {
            ok.thumb=false
        }
        geralView()
    })
}

function Main() {
    baseFuncs()
 
}
Main()