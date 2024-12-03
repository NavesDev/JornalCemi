export async function LogTry(em,pass){
    try{
        let req=await fetch("login.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: new URLSearchParams({
                logtry:true,
                email: em,
                senha: pass
            })
        })
       
        return await req.json();
    } catch(error){
        console.error("Erro de envio : "+error)
    }
}

export async function RegTry(em,pass,name,date){
    try{
        let req=await fetch("login.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: new URLSearchParams({
                regtry:true,
                email: em,
                senha: pass,
                username:name,
                birthday:date
            })
        })
       
        return await req.json()
    } catch(error){
        console.error("Erro de envio : "+error)
    }
}

export async function logOut(){
    try{
        let req=await fetch("login.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: new URLSearchParams({
                logOut:true
            })
        });
       
        return await req.json();
    } catch(error){
        console.error("Erro de envio : "+error)
    }
}
export async function DataVerify(dataType,data){
    try{
        let req=await fetch("DataVerify.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: new URLSearchParams({
                DT:dataType,
                data:data
            })
        })
        return await req.json()
    }catch(error){
        console.error(error)
    }
}

export async function GetDate(){
    try{
        let req=await fetch("config.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: new URLSearchParams({
                needDate:true
            })
        })
        return await req.json()
    }catch(error){
        console.error(error)
    }
}

export async function GetBody(params) {
    try{
        let req=await fetch("dataRequest.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: new URLSearchParams({
                bodyRequest:true
            })
        })
        return await req.json()
    }catch(error){
        console.error(error)
    }
}

export async function GetEnters(){
    try{
        let req=await fetch("dataRequest.php",{
            method: "POST",
            headers: {
                "Content-Type": "application/x-www-form-urlencoded" 
            },
            body: new URLSearchParams({
                enterRequest:true
            })
        })
        return await req.json()
    }catch(error){
        console.error(error)
    }
}

export async function NewPub(pubTitle,pubDesc,pubType,pubThumb) {
    try{
        const fData = new FormData()
        fData.append("newPub",TRUE)
        fData.append("pTitle",pubTitle)
        fData.append("pDesc",pubDesc)
        fData.append("pType",pubType)
        fData.append("pThumb",pubThumb)

        let req=await fetch("minhas_noticias.php",{
            method: "POST",
            body: fData
        })
        return await req.json()
    }catch(error){
        console.error(error)
    } 
}