import { GetEnters,logOut } from "./reqs.js";

async function enterScript() {
    const req = await GetEnters();
    const temp = document.getElementById("secTemplate");
    const secSpace = document.getElementById("secSpace");
    if(req.success){
        const enters = req.got;
        for(const [key,value] of Object.entries(enters)){
            const clone = temp.cloneNode(true);
            clone.className = "sec"
            clone.id = ""
            clone.querySelector("#secIp").innerText = value.ip
            clone.querySelector("#secLocal").value = value.local
            clone.querySelector("#secDate").value = value.dda.substring(0,10)
            if(value.thisMachine){
                const text = document.createElement("p")
                text.innerText = "(Este dispositivo)"
                text.className = "miniObs"
                clone.appendChild(text);
            }
            secSpace.appendChild(clone)
        }
    }
}

async function logingOut(){
    let response = await logOut()
    if(response.success){
        window.location.href = "/jornalcemic";
    } else {
        window.location.reload();
    }
}

function main() {
    document.getElementById("exit-but").addEventListener("click",logingOut)
    enterScript();
}

main();