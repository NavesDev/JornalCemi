class Row{
    static AllRows=[];
    static currentId=0;
    static currentOrder=0;
    //os tipos são (1 = titulo 2 = subtitulo 3 = paragrafo)
    constructor(type=3,candestroy=true,canreorder=true){
        this.type=type
        this.order = ++currentOrder
        this.obj = Row.newObj(type,this.order);
        this.editor = this.newEditor(this.obj,candestroy,canreorder);
        this.id = ++Row.currentId
        Row.AllRows.push(this)
    }
    objChange(newType,order){
        const ownType = this.type;
        let lastValue = ""
        
        if(ownType==3){
            lastValue = this.obj.innerText;
        } else if(ownType==1 || ownType==2){
            lastValue = this.obj.value;
        } else {
            lastValue = null
        }
        let el = null;
        if(newType==3){
            this.type=newType
            el = document.createElement("textarea")
            el.className="parag needOrder"
            el.innerText = lastValue
            el.placeholder = "Novo paragrafo"
        } else if(newType==2){
            this.type = newType
            el = document.createElement("input")
            el.className="subtitulo needOrder"
            el.value = lastValue
            el.placeholder = "Novo subtítulo"
        } else if(newType==1){
            this.type = newType
            el = document.createElement("input")
            el.className="titulo needOrder"
            el.value = lastValue
            el.placeholder = "Novo título"
        }

        if(el){
            this.obj.replaceWith(el)
            this.obj = el
            this.type = newType
            el.setAttribute("data-order", String(order));
        }
        return el
    }

    static newObj(type) {
        let el = null;
        if(type==1){
            el = document.createElement("input")
            el.className="titulo needOrder"
            el.placeholder = "Novo título"
        } else if(type==2){
            el = document.createElement("input")
            el.className="subtitulo needOrder"
            el.placeholder = "Novo subtítulo"

        } else if(type==3){
            el = document.createElement("textarea")
            el.className="parag needOrder"
            el.placeholder = "Novo paragrafo"
            el.addEventListener('input', (ev)=> {
                ev.target.style.height = 'auto'; 
                ev.target.style.height = ev.target.scrollHeight + 'px'; 
            });
        }
    
        if(el){
            el.setAttribute("data-order", String());
            document.getElementById("editing").appendChild(el)
        }
        return el;
    }

    static reorder() {
        // Pega todos os elementos com a classe "item"
        const container = document.querySelector("#editing");
        const items = Array.from(container.getElementsByClassName("needOrder"));

        // Ordena os elementos com base no atributo 'data-order'
        items.sort((a, b) => {
            return a.getAttribute("data-order") - b.getAttribute("data-order");
        });

        // Reanexa os elementos ao contêiner na nova ordem
        items.forEach(item => container.appendChild(item));
    }

    newEditor(obj,candestroy,canreorder){
        const clone = document.getElementById("fmenuTemplate").cloneNode(true)
        clone.id=''
        
        clone.style.display='flex'
        const cd = document.getElementById("editing").insertBefore(clone,obj)
    
        cd.setAttribute("data-order", String(obj.getAttribute("data-order")-0.5));
        cd.querySelector("#sectypes").value = this.type
        cd.querySelector("#sectypes").addEventListener("change", (ev)=>{
            const vc = ev.target.value
            if(vc!=this.type){   
                this.objChange(vc,obj.getAttribute("data-order"))
            }
        })
        if(candestroy){

        } else {
            clone.removeChild(clone.querySelector("#secDestroy"))
        }
        if(canreorder){
            clone.querySelector("#secUp").addEventListener("click",(ev)=>{
                let oborder=obj.getAttribute("data-order")
                if(oborder<Row.currentOrder && oborder>2){
                    lastob =document.getElementById("editing").querySelector(`[data-order="${oborder+1}"]`)
                    lasteditor = document.getElementById("editing").querySelector(`[data-order="${oborder+0.5}"]`)
                    lastob.setAttribute("data-order",String(oborder))
                    lasteditor.setAttribute("data-order",String(cd.getAttribute("data-order")))
                    obj.setAttribute("data-order",String(oborder+1))
                    cd.setAttribute("data-order",String(obj.getAttribute("data-order")-0.5))
                } 
            })
        } else {
            clone.removeChild(clone.querySelector("#secUp"))
            clone.removeChild(clone.querySelector("#secDown"))
        }
        return cd
    }
}
const basetit = new Row(1,false,false);
const basesub = new Row(2)
const basep = new Row(3)
const parags = document.getElementsByClassName("parag");

